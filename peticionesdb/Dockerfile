FROM python:3.9-slim
WORKDIR /peticionesdir
COPY dataFrameProyecto.csv /peticionesdir/dataFrameProyecto.csv
COPY insertarClientes.py /peticionesdir/insertarClientes.py
COPY procesar_e_insertar_usuarios.py /peticionesdir/procesar_e_insertar_usuarios.py
COPY requirements.txt /peticionesdir/requirements.txt
COPY run.sh /peticionesdir/run.sh
RUN chmod a+x run.sh
RUN pip install --no-cache-dir -r requirements.txt
CMD ["./run.sh"]

#con Oracle linux
#RUN microdnf install -y python39 && \
#    curl -sS https://bootstrap.pypa.io/get-pip.py | python3.9 && \
#    microdnf clean all
#RUN pip3 install --no-cache-dir -r requirements.txt

#RUN dnf install -y python39 && \
#    dnf clean all
#RUN yum install -y python39 && \
#    yum clean all
#RUN microdnf install -y python39 && \
#    microdnf clean all
#RUN apt-get install -y python3
#CMD ["python", "procesar_e_insertar_usuarios.py"]
#RUN pip install --no-cache-dir -r requirements.txt
#RUN python insertarClientes.py
#RUN python procesar_e_insertar_usuarios.py

