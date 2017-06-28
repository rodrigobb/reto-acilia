# Acilia Reto deSymfony

# Build de la instancia
docker build -t acilia/reto-participante .

# Run de la instancia
docker run -it -p 8800:80 --name acilia_reto_participante acilia/reto-participante apache2ctl -DFOREGROUND

# Remove de la instancia
docker rm acilia_reto_participante
