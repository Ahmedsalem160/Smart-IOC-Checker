# Load JSON data from the file
$jsonData = Get-Content "C:\Users\moham\Downloads\input2.txt" | ConvertFrom-Json

# Initialize arrays to store IOCs by type
$FileHashSHA1 = @()
$FileHashSHA256 = @()
$FileHashMD5 = @()
$hostname = @()
$domain = @()
$ipv4 = @()

# Iterate over each report in the JSON data
foreach ($report in $jsonData.res) {
    # Iterate over each indicator in the report
    foreach ($indicator in $report.indicators) {
        switch ($indicator.type) {
            "FileHash-SHA1" {
                $FileHashSHA1 += $indicator.indicator
            }
            "FileHash-SHA256" {
                $FileHashSHA256 += $indicator.indicator
            }
            "FileHash-MD5" {
                $FileHashMD5 += $indicator.indicator
            }
            "hostname" {
                $hostname += $indicator.indicator
            }
            "domain" {
                $domain += $indicator.indicator
            }
            "IPv4" {
                $ipv4 += $indicator.indicator
            }
        }
    }
}

# Function to calculate file hashes
function Get-FileHashTypes {
    param(
        [string]$filePath
    )
    $hashes = @{
        SHA1   = (Get-FileHash -Algorithm SHA1 -Path $filePath).Hash
        SHA256 = (Get-FileHash -Algorithm SHA256 -Path $filePath).Hash
        MD5    = (Get-FileHash -Algorithm MD5 -Path $filePath).Hash
    }
    return $hashes
}
# Get active TCP connections
    $connections = Get-NetTCPConnection | Select-Object -Property RemoteAddress, State

    # Compare with IP IOCs
    foreach ($connection in $connections) {
        if ($ipv4 -contains $connection.RemoteAddress) {
            Write-Output "Suspicious connection found: $($connection.RemoteAddress) (IP Match)"
        }
    }

    # Get DNS Cache for domain lookups
    $dnsCache = Get-DnsClientCache | Select-Object -Property Name

    # Compare with Domain IOCs
    foreach ($entry in $dnsCache) {
        if ($domain -contains $entry.Name) {
            Write-Output "Suspicious domain found in DNS Cache: $($entry.Name) (Domain Match)"
        }
    }
# Scan file system and compare hashes
$pathToScan = "E:\A"
$files = Get-ChildItem -Path $pathToScan -Recurse -File

foreach ($file in $files) {
    $fileHashes = Get-FileHashTypes -filePath $file.FullName

    # Compare with SHA1
    if ($FileHashSHA1 -contains $fileHashes.SHA1) {
        Write-Output "Malicious file found: $($file.FullName) (SHA1 Match)"
    }

    # Compare with SHA256
    if ($FileHashSHA256 -contains $fileHashes.SHA256) {
        Write-Output "Malicious file found: $($file.FullName) (SHA256 Match)"
    }

    # Compare with MD5
    if ($FileHashMD5 -contains $fileHashes.MD5) {
        Write-Output "Malicious file found: $($file.FullName) (MD5 Match)"
    }
}
# Function to check active network connections against IOCs
#function Check-NetworkConnections {
   # param(
      #  [array]$ipv4,
      #  [array]$domain
   # )

    
#}


