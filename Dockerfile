FROM webdevops/php-nginx:8.1

# Default powerline10k theme, no plugins installed
RUN sh -c "$(wget -O- https://github.com/deluan/zsh-in-docker/releases/download/v1.1.2/zsh-in-docker.sh)"

# Uncomment following lines if you're using a Macbook with M1 processor or comment it if you're not using one.
#
 RUN set -eux; \
   wget --quiet -O /usr/local/bin/go-replace https://github.com/webdevops/goreplace/releases/download/1.1.2/gr-arm64-linux; \
   chmod +x /usr/local/bin/go-replace;

RUN apt-get update && \
        apt-get install -y tesseract-ocr tesseract-ocr-fra && \
        # Nettoyer le cache du gestionnaire de paquets pour réduire la taille de l'image
        apt-get clean && \
        rm -rf /var/lib/apt/lists/* \
