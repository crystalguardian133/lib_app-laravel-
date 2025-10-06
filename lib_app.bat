@echo off
cd /d "%~dp0"

REM Create desktop shortcut with logo icon
powershell -Command "
$WshShell = New-Object -comObject WScript.Shell;
$Shortcut = $WshShell.CreateShortcut([Environment]::GetFolderPath('Desktop') + '\\Lib App.lnk');
$Shortcut.TargetPath = '%~f0';
$Shortcut.WorkingDirectory = '%~dp0';
$Shortcut.IconLocation = '%~dp0public\\images\\logo.ico,0';
$Shortcut.Description = 'Julita Public Library Application';
$Shortcut.Save();
"

echo Desktop shortcut created successfully!
echo.
echo Starting Laravel development server...
php artisan serve