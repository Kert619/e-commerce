FROM node:lts-alpine

# make the 'app' folder the current working directory
WORKDIR /app

# copy both 'package.json' and 'package-lock.json' (if available)
COPY --chown=app:app package*.json ./

# install project dependencies
RUN npm install

# copy project files and folders to the current working directory (i.e. 'app' folder)
# to ensure such files are owned by the configured user, use the COPY --chown flag:
COPY  . /app

# expose port 
EXPOSE 8080

# start the dev server
CMD [ "npm", "run", "dev" ]