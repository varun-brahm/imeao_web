@echo off

REM Set the Yii2 console command
set YII_CONSOLE_CMD=php yii

REM Check if the required directories and files exist
if not exist "config\web.php" (
  echo The Yii2 application does not exist in the current directory.
  exit /b 1
)

REM Run the Yii2 code cleanup command
%YII_CONSOLE_CMD% cleanup
