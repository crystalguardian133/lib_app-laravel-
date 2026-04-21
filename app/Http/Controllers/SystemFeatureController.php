<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class SystemFeatureController extends Controller
{
    public function index(Request $request)
    {
        return response()->json($this->buildFeatureInventory(null));
    }

    public function show(Request $request, string $feature)
    {
        $payload = $this->buildFeatureInventory($feature);

        if (empty($payload['feature'])) {
            return response()->json([
                'message' => 'Feature not found.',
            ], 404);
        }

        return response()->json($payload);
    }

    protected function buildFeatureInventory(?string $featureFilter): array
    {
        $definitions = $this->featureDefinitions();
        $routes = collect(Route::getRoutes())
            ->map(fn ($route) => $this->formatRoute($route))
            ->filter(fn (array $route) => !Str::startsWith($route['uri'], '_ignition'))
            ->values();

        $features = collect($definitions)
            ->map(function (array $definition, string $key) use ($routes) {
                $matchedRoutes = $routes->filter(function (array $route) use ($definition) {
                    foreach ($definition['patterns'] as $pattern) {
                        if (Str::is($pattern, $route['uri']) || ($route['name'] && Str::is($pattern, $route['name']))) {
                            return true;
                        }
                    }

                    return false;
                })->values();

                return [
                    'key' => $key,
                    'label' => $definition['label'],
                    'description' => $definition['description'],
                    'route_count' => $matchedRoutes->count(),
                    'routes' => $matchedRoutes,
                ];
            })
            ->filter(function (array $feature) use ($featureFilter) {
                if ($featureFilter === null) {
                    return true;
                }

                return $feature['key'] === $featureFilter;
            })
            ->values();

        $selectedFeature = $featureFilter === null
            ? null
            : $features->first();

        $unclassifiedRoutes = $routes->filter(function (array $route) use ($definitions) {
            foreach ($definitions as $definition) {
                foreach ($definition['patterns'] as $pattern) {
                    if (Str::is($pattern, $route['uri']) || ($route['name'] && Str::is($pattern, $route['name']))) {
                        return false;
                    }
                }
            }

            return true;
        })->values();

        return [
            'generated_at' => now()->toIso8601String(),
            'feature' => $selectedFeature,
            'features' => $features,
            'unclassified_routes' => $unclassifiedRoutes,
        ];
    }

    protected function formatRoute($route): array
    {
        $middleware = $route->gatherMiddleware();
        $roles = [];
        $permissions = [];
        $flags = [];

        foreach ($middleware as $entry) {
            if (Str::startsWith($entry, 'role:')) {
                $roles = array_values(array_unique(array_merge($roles, preg_split('/[|,]/', Str::after($entry, 'role:')) ?: [])));
            }

            if (Str::startsWith($entry, 'permission:')) {
                $permissions = array_values(array_unique(array_merge($permissions, preg_split('/[|,]/', Str::after($entry, 'permission:')) ?: [])));
            }

            if ($entry === 'restrict.assistant') {
                $flags[] = 'assistant_blocked';
            }
        }

        return [
            'methods' => $route->methods(),
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'action' => $route->getActionName(),
            'middleware' => $middleware,
            'access' => [
                'roles' => array_values(array_filter(array_map('trim', $roles))),
                'permissions' => array_values(array_filter(array_map('trim', $permissions))),
                'flags' => $flags,
            ],
        ];
    }

    protected function featureDefinitions(): array
    {
        return [
            'auth' => [
                'label' => 'Authentication and Session Management',
                'description' => 'Login, logout, password reset, sessions, and force-logout controls.',
                'patterns' => [
                    'login',
                    'logout',
                    'forgot-password*',
                    'reset-password',
                    'sessions*',
                    'auth/force-logout-status',
                    'users/*/clear-force-logout',
                ],
            ],
            'dashboard' => [
                'label' => 'Dashboard and Analytics',
                'description' => 'Summary views, dashboard charts, and reporting feeds.',
                'patterns' => [
                    'dashboard*',
                    'api/analytics/*',
                ],
            ],
            'books' => [
                'label' => 'Books',
                'description' => 'Book CRUD, genre filters, and media helpers.',
                'patterns' => [
                    'books*',
                    'api/books*',
                    'api/media/*',
                ],
            ],
            'members' => [
                'label' => 'Members',
                'description' => 'Member CRUD, lookups, QR/card support, and verification helpers.',
                'patterns' => [
                    'members*',
                    'api/members*',
                ],
            ],
            'borrowing' => [
                'label' => 'Borrowing and Returns',
                'description' => 'Borrowing workflow, overdue notifications, and return processing.',
                'patterns' => [
                    'borrow*',
                    'transactions*',
                    'api/notifications/overdue*',
                ],
            ],
            'timelog' => [
                'label' => 'Time Logs',
                'description' => 'Time in/out, QR scans, and time log search.',
                'patterns' => [
                    'timelog*',
                    'qr-scanner',
                    'time-log/*',
                ],
            ],
            'notifications' => [
                'label' => 'Notifications',
                'description' => 'Overdue and due-soon notification flows.',
                'patterns' => [
                    'notifications*',
                    'api/notifications/overdue*',
                ],
            ],
            'analytics' => [
                'label' => 'Analytics APIs',
                'description' => 'Borrow trends, activity heatmaps, and peak-hour analysis.',
                'patterns' => [
                    'api/analytics/*',
                ],
            ],
            'system-logs' => [
                'label' => 'System Logs',
                'description' => 'Audit and system log review and clearing.',
                'patterns' => [
                    'system-logs*',
                ],
            ],
            'users' => [
                'label' => 'User Management',
                'description' => 'Admin user administration, role changes, permissions, and sessions.',
                'patterns' => [
                    'admin/users*',
                    'admin/sessions*',
                    'users/*clear-force-logout',
                    'admin/update-profile',
                ],
            ],
            'chatbot' => [
                'label' => 'Chatbot',
                'description' => 'Chatbot message handling.',
                'patterns' => [
                    'chatbot/message',
                ],
            ],
            'audio' => [
                'label' => 'Audio Assets',
                'description' => 'System audio file listing for the UI.',
                'patterns' => [
                    'api/audio/files',
                ],
            ],
            'system' => [
                'label' => 'System Feature Registry',
                'description' => 'Route inventory endpoint for feature discovery.',
                'patterns' => [
                    'api/system/features*',
                ],
            ],
        ];
    }
}
