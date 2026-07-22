#!/usr/bin/env bash

TARGET_URL="http://cyber.blog:8000/articles/search?query=test"
TOTAL_REQUESTS=100

echo "Target: $TARGET_URL"
echo "Numero richieste: $TOTAL_REQUESTS"
echo

start_time=$(date +%s)

for ((i = 1; i <= TOTAL_REQUESTS; i++)); do
    status_code=$(curl \
        --silent \
        --output /dev/null \
        --write-out "%{http_code}" \
        "$TARGET_URL")

    echo "Richiesta $i: HTTP $status_code"
done

end_time=$(date +%s)
elapsed_time=$((end_time - start_time))

echo
echo "Test completato in ${elapsed_time} secondi."