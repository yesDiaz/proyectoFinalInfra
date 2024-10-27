FROM node
EXPOSE 3001
WORKDIR /microUsuarios
COPY src /microUsuarios/src
COPY package-lock.json /microUsuarios/package-lock.json
COPY package.json /microUsuarios/package.json
#COPY src/controllers /microUsuarios/src/controllers
#COPY src/models /microUsuarios/src/models
#COPY src/index.js /microUsuarios/src/index.js
RUN npm install
CMD node src/index.js
