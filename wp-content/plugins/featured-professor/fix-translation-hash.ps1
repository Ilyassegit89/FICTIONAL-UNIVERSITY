# Auto-fix translation JSON hash
$correctHash = "dfbff627e6c248bcb3b61d7d06da9ca9"
$languagesPath = ".\languages\"

Get-ChildItem -Path $languagesPath -Filter "featured-professor-*.json" | ForEach-Object {
    if ($_.Name -notmatch $correctHash) {
        $newName = $_.Name -replace '-[a-f0-9]{32}\.json$', "-$correctHash.json"
        Rename-Item -Path $_.FullName -NewName $newName -Force
        Write-Host "Renamed: $($_.Name) -> $newName"
    }
}