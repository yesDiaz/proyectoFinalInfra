FROM node
EXPOSE 3003
WORKDIR /microOrdenes
COPY src /microOrdenes/src
COPY package-lock.json /microOrdenes/package-lock.json
COPY package.json /microOrdenes/package.json
#COPY src/controllers /microOrdenes/src/controllers
#COPY src/models /microOrdenes/src/models
#COPY src/index.js /microOrdenes/src/index.js
RUN npm install
CMD node src/index.js