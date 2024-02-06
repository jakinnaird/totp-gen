# TOTP-GEN
Generate TOTP QR codes to populate a password manager. Useful for shared authentication during an in person interaction.

## Building

docker run --rm --user \$(id -u):\$(id -g) -v \$(pwd):/app composer update

docker build . -t totp-gen:latest

## Development

docker run -it --rm -p 8080:8080 -v \$(pwd):/usr/src/app totp-gen:latest

## Production

docker run -it --rm -p 8080:8080 totp-gen:latest
