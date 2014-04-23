Set WshShell = CreateObject("WScript.Shell")
WshShell.Run chr(34) & "C:\xampp\htdocs\elearning\autoBackup.bat" & Chr(34), 0
Set WshShell = Nothing