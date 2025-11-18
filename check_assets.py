#!/usr/bin/env python3
"""
Asset Link Checker for Moonlit Detailing
Scans PHP files for asset references and checks if they exist
"""

import os
import re
from pathlib import Path

# Colors for terminal output
RED = '\033[0;31m'
GREEN = '\033[0;32m'
YELLOW = '\033[1;33m'
BLUE = '\033[0;34m'
NC = '\033[0m'  # No Color

def check_assets_in_file(file_path, base_dir):
    """Check all asset references in a single file"""
    broken_assets = []

    try:
        with open(file_path, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()
            lines = content.split('\n')

            # Patterns to match asset references
            patterns = [
                r'(?:src|href)=["\']([^"\']+\.(?:css|js|png|jpg|jpeg|gif|svg|ico|woff|woff2|ttf|eot))["\']',
                r'url\(["\']?([^"\'()]+\.(?:png|jpg|jpeg|gif|svg))["\']?\)',
            ]

            for line_num, line in enumerate(lines, 1):
                for pattern in patterns:
                    matches = re.finditer(pattern, line, re.IGNORECASE)
                    for match in matches:
                        asset_path = match.group(1)

                        # Skip external URLs
                        if asset_path.startswith(('http://', 'https://', '//', 'data:')):
                            continue

                        # Skip PHP variables
                        if '<?php' in asset_path or '$' in asset_path:
                            continue

                        # Resolve relative paths
                        asset_path = asset_path.lstrip('./')

                        # Construct full path
                        if asset_path.startswith('assets/'):
                            full_path = base_dir / asset_path
                        else:
                            # Relative to current file
                            file_dir = Path(file_path).parent
                            full_path = file_dir / asset_path

                        # Normalize path
                        full_path = full_path.resolve()

                        # Check if file exists
                        if not full_path.exists():
                            broken_assets.append({
                                'asset': asset_path,
                                'line': line_num,
                                'full_path': str(full_path)
                            })

    except Exception as e:
        print(f"{RED}Error reading {file_path}: {e}{NC}")

    return broken_assets

def scan_directory(directory, file_extensions=('.php', '.html')):
    """Scan directory for PHP/HTML files and check assets"""
    print(f"{BLUE}=== Moonlit Detailing - Asset Link Checker ==={NC}\n")

    base_dir = Path(directory)
    all_broken = {}
    total_files = 0

    # Find all PHP and HTML files
    for ext in file_extensions:
        for file_path in base_dir.rglob(f'*{ext}'):
            # Skip vendor directories
            if 'vendor' in str(file_path) or 'node_modules' in str(file_path):
                continue

            total_files += 1
            relative_path = file_path.relative_to(base_dir)

            broken = check_assets_in_file(file_path, base_dir)
            if broken:
                all_broken[str(relative_path)] = broken

    # Print results
    print(f"Scanned {total_files} files\n")

    if not all_broken:
        print(f"{GREEN}✓ All asset references are valid!{NC}\n")
        return

    print(f"{RED}Found broken asset references:{NC}\n")

    for file_path, broken_list in sorted(all_broken.items()):
        print(f"{YELLOW}📄 {file_path}{NC}")
        for item in broken_list:
            print(f"  {RED}✗{NC} Line {item['line']}: {item['asset']}")
            print(f"     Expected at: {item['full_path']}")
        print()

    total_broken = sum(len(broken_list) for broken_list in all_broken.values())
    print(f"{RED}Total broken references: {total_broken}{NC}")
    print(f"Files with issues: {len(all_broken)}")

if __name__ == '__main__':
    project_root = Path('/Users/elizabethoyekunle/Documents/Personal/Tecvator/MoonlitDetailing/public')
    scan_directory(project_root)

