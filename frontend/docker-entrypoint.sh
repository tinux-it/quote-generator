#!/bin/sh

# Create the runtime environment config
cat <<EOF > ./public/runtime-env.js
window.NEXT_PUBLIC_API_URL="${NEXT_PUBLIC_API_URL}";
window.NEXT_PUBLIC_APP_ENV="${NEXT_PUBLIC_APP_ENV}";
window.NEXT_PUBLIC_APP_NAME="${NEXT_PUBLIC_APP_NAME}";
EOF

exec "$@"
