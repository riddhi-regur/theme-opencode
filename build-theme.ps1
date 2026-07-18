# ============================================================
#  Lawfirmpro Theme — Build Script
#  Creates a distributable zip at D:\Lawfirmpro.zip
#  Structure inside zip: Theme/ (containing all theme files)
# ============================================================

$ErrorActionPreference = 'Stop'

$sourceDir   = "C:\Users\Atharv\OneDrive\Desktop\theme-opencode"
$outputZip   = "C:\Users\Atharv\OneDrive\Desktop\Lawfirmpro.zip"
$stagingRoot = Join-Path ([System.IO.Path]::GetTempPath()) "Lawfirmpro-build"

# ── Clean staging area ──────────────────────────────────────
if (Test-Path $stagingRoot) {
    Remove-Item $stagingRoot -Recurse -Force
}

# ── Create Theme/ subfolder and copy (exclude .git) ────────
$stagingTheme = Join-Path $stagingRoot "Theme"
New-Item -ItemType Directory -Path $stagingTheme -Force | Out-Null

Get-ChildItem $sourceDir -Exclude ".git", "node_modules", ".gitignore", "build-theme.ps1" |
    ForEach-Object {
        Copy-Item $_.FullName -Destination $stagingTheme -Recurse -Force
    }

# ── Create zip (files only — no directory entries) ──────────
if (Test-Path $outputZip) {
    Remove-Item $outputZip -Force
}

$files = Get-ChildItem $stagingRoot -Recurse -File
$tempZip = "$stagingRoot.zip"

Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem

$archive = [System.IO.Compression.ZipFile]::Open($tempZip, 'Create')
try {
    foreach ($file in $files) {
        $entryName = $file.FullName.Substring($stagingRoot.Length + 1).Replace('\', '/')
        [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile($archive, $file.FullName, $entryName) | Out-Null
    }
} finally {
    $archive.Dispose()
}

Move-Item $tempZip $outputZip -Force

# ── Report ──────────────────────────────────────────────────
$size = [math]::Round((Get-Item $outputZip).Length / 1MB, 1)
Write-Host "Build complete: $outputZip ($size MB)" -ForegroundColor Green

# ── Clean staging ───────────────────────────────────────────
Remove-Item $stagingRoot -Recurse -Force
