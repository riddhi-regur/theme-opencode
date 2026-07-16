# ============================================================
#  Lawfirmpro Theme — Build Script
#  Creates a distributable zip at D:\Lawfirmpro.zip
#  Structure inside zip: theme/ (containing all theme files)
# ============================================================

$ErrorActionPreference = 'Stop'

$sourceDir   = "C:\Users\Riddhi Bhatt\Desktop\Theme"
$outputZip   = "D:\Lawfirmpro.zip"
$stagingRoot = "$env:TEMP\Lawfirmpro-build"

# ── Clean staging area ──────────────────────────────────────
if (Test-Path $stagingRoot) {
    Remove-Item $stagingRoot -Recurse -Force
}

# ── Create theme/ subfolder and copy (exclude .git) ────────
$stagingTheme = Join-Path $stagingRoot "theme"
New-Item -ItemType Directory -Path $stagingTheme -Force | Out-Null

Get-ChildItem $sourceDir -Exclude ".git", "node_modules", ".gitignore" |
    ForEach-Object {
        Copy-Item $_.FullName -Destination $stagingTheme -Recurse -Force
    }

# ── Create zip ──────────────────────────────────────────────
if (Test-Path $outputZip) {
    Remove-Item $outputZip -Force
}

Compress-Archive -Path "$stagingRoot\*" -DestinationPath $outputZip -Force

# ── Report ──────────────────────────────────────────────────
$size = [math]::Round((Get-Item $outputZip).Length / 1MB, 1)
Write-Host "Build complete: $outputZip ($size MB)" -ForegroundColor Green

# ── Clean staging ───────────────────────────────────────────
Remove-Item $stagingRoot -Recurse -Force
