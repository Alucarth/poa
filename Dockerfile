FROM debian
LABEL maintainer="Leandro David Torrez Salinas"
RUN apt-get update \
	&& apt-get install -y \
	apt-transport-https \
	git \
	curl \
	wget \
	lsb-release \
	ca-certificates \
	&& wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg \
	&& sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list' \
	&& apt-get update \
	&& apt-get install -y \
	nano \
	nginx php7.2 php7.2-common php7.2-cli php7.2-fpm php7.2-mysql php7.2-pgsql php7.2-xml php7.2-curl php7.2-mbstring php7.2-zip 
	
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
	&& curl -sL https://deb.nodesource.com/setup_11.x | bash - \
	&& apt-get install -y nodejs 

EXPOSE 80

CMD ["nginx","-g","daemon off;"]

