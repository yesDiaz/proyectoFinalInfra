FROM node
EXPOSE 3002
WORKDIR /microProductos
COPY src /microProductos/src
COPY package-lock.json /microProductos/package-lock.json
COPY package.json /microProductos/package.json
#COPY src/controllers /microProductos/src/controllers
#COPY src/models /microProductos/src/models
#OPY src/index.js /microProductos/src/index.js
RUN npm install
CMD node src/index.js