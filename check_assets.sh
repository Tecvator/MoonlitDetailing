#!/bin/bash

# Asset Link Checker for Moonlit Detailing
# This script checks all asset references in PHP files and verifies they exist

echo "=== Moonlit Detailing - Asset Link Checker ==="
echo ""

# Color codes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

BROKEN_COUNT=0
CHECKED_COUNT=0

# Function to check if file exists
check_asset() {
    local file_path=$1
    local source_file=$2
    local line_num=$3

    CHECKED_COUNT=$((CHECKED_COUNT + 1))

    if [ -f "$file_path" ]; then
        echo -e "${GREEN}✓${NC} $file_path"
    else
        echo -e "${RED}✗${NC} $file_path"
        echo -e "   ${YELLOW}Referenced in:${NC} $source_file:$line_num"
        BROKEN_COUNT=$((BROKEN_COUNT + 1))
    fi
}

echo "Scanning dashboard signin.php..."
echo ""

cd /Users/elizabethoyekunle/Documents/Personal/Tecvator/MoonlitDetailing/public/dashboard

# Extract all asset references from signin.php
grep -n 'src=\|href=' signin.php | grep -E 'assets/|img/' | while IFS= read -r line; do
    line_num=$(echo "$line" | cut -d: -f1)
    content=$(echo "$line" | cut -d: -f2-)

    # Extract asset path
    asset=$(echo "$content" | grep -oP '(href|src)="\K[^"]+' | head -1)

    # Skip external URLs
    if [[ $asset =~ ^https?:// ]]; then
        continue
    fi

    # Skip PHP variables
    if [[ $asset =~ \$|php ]]; then
        continue
    fi

    # Convert relative path to absolute
    if [[ $asset == assets/* ]] || [[ $asset == ./assets/* ]]; then
        asset_path="${asset#./}"
        full_path="/Users/elizabethoyekunle/Documents/Personal/Tecvator/MoonlitDetailing/public/dashboard/$asset_path"
        check_asset "$full_path" "signin.php" "$line_num"
    fi
done

echo ""
echo "=== Summary ==="
echo "Total assets checked: $CHECKED_COUNT"
echo -e "${RED}Broken links: $BROKEN_COUNT${NC}"
echo ""

if [ $BROKEN_COUNT -eq 0 ]; then
    echo -e "${GREEN}All assets are accessible!${NC}"
else
    echo -e "${RED}Some assets are missing. Please review the output above.${NC}"
fi

