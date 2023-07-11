from lib.BddHelper import BddHelper
import re
from _thread import *
from datetime import datetime
from io import BytesIO
from PIL import Image
import base64
import json
import os
import traceback
import time
import pprint
import select
import socket
import shutil
import sys
import time 
from pymongo import MongoClient

start_time = time.time()
end_time = time.time()


client = MongoClient('localhost', 27017)
db = client['iotonrumbo']
bddhelper = BddHelper(db)

#Cambiar directorio donde se va a guardar las imagenes 
directorioBase = "C:/tem/16-06-2023/iot_socket_server/images/"
directorioBaseJson = "C:/tem/16-06-2023/iot_socket_server/images/"

sockets = []

BUFF_SIZE = 16384
ThreadCount = 0

for port in range(2001, 2006):
    #AF_INET dominio del conectos 
    # Especifica que vamos a utilizar IP 
    #SOCK_STREAM conector Ipv4
    server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_RCVBUF, BUFF_SIZE)

    try:
        # server_socket.bind(('68.183.141.197', port))
        server_socket.bind(('0.0.0.0', port))
    except socket.error as e:
        print(str(e))
    print(str(port) + ' Socket is listening..')
    sockets.append(server_socket)


empty = []

temporalJsonDict = {}
longitudPartes = 5

# CREA EL ARCHIVO JSON TEMPORAL Y LUEGO VERIFICA PARA CREAR LAS IMAGENES
def procesarJsonImagen(recive_data, json_string, direccion_ip):
    direccion_ip_cadena = direccion_ip.replace('.', '_')
    local_directorioBaseJson = directorioBaseJson + direccion_ip_cadena + '/'
    os.makedirs(local_directorioBaseJson, exist_ok=True)
    if recive_data["image_id"] not in temporalJsonDict:
        temporalJsonDict[recive_data["image_id"]] = {}
    temporalJsonDict[recive_data["image_id"]
                     ][recive_data["part"]] = recive_data

    directorioDeviceJson = local_directorioBaseJson + \
        recive_data["image_id"] + "/"
    try:
        os.makedirs(directorioDeviceJson, exist_ok=True)
    except:
        try:
            os.makedirs(directorioDeviceJson, exist_ok=True)
        except:
            print(f"Directorio {directorioDeviceJson} ya existe")

    with open(directorioDeviceJson + recive_data["part"]+'.json', 'w') as f:
        f.write(json_string)

    # pprint.pprint(temporalJsonDict[recive_data["image_id"]])
    # print(len(temporalJsonDict[recive_data["image_id"]]))
    if len(temporalJsonDict[recive_data["image_id"]]) == longitudPartes:
        base64Image = ""
        device_id = recive_data["device_id"]
        for num in range(0, longitudPartes):
            jsonPath = directorioDeviceJson + str(num) + ".json"
            with open(jsonPath) as f:
                data = json.load(f)
            base64Image += data["image_data"]
            # base64Image += temporalJsonDict[recive_data["image_id"]][str[num]]["image_data"]
        try:
            img_data = base64.b64decode(base64Image)
            img = Image.open(BytesIO(img_data))
            now = datetime.now()
            directorioDeviceImages = directorioBase + \
                device_id + now.strftime('/%Y/%m/%d/%H/%M/')
            directorioDeviceImagesProcesadas = directorioBase + \
                device_id + now.strftime('/%Y/%m/%d/%H/%M/')+'/fd/'
            # print(directorioDeviceImages)
            os.makedirs(directorioDeviceImages, exist_ok=True)
            os.makedirs(directorioDeviceImagesProcesadas, exist_ok=True)
            nameImage = now.strftime('%Y%m%d%H%M%S%f')+'.jpg'
            nameProcesadaImage = now.strftime('%Y%m%d%H%M%S%f')+'.jpg'
            img.save(directorioDeviceImages + nameImage, "JPEG")
            img.save(directorioBase + device_id +
                     "/remote_image_last.jpg", "JPEG")

            # -----------------------------------------
            # GUARDAR EN LA BASE DE DATOS
            # -----------------------------------------
            currentDevice = bddhelper.getAsignacionByDevice(device_id)
            print(currentDevice)
            if (currentDevice != None):
                bddhelper.addTracking({
                    "asignacion_id": currentDevice["_id"],
                    "ip": direccion_ip,
                    "fecha": now,
                    "basepath": directorioDeviceImages.replace(directorioBase,''),
                    "imagename": nameImage,
                    "fd": "0",
                    "estado":""
                })

            print("Llega la Imagen " + now.strftime('%Y%m%d%H%M%S'))
        except:
            print("Error de Imagen")

        try:
            del temporalJsonDict[recive_data["image_id"]]
        except:
            print("No se elimino la clave")
        # asegúrate de que el directorio exista
        if os.path.exists(directorioDeviceJson):
            # utiliza shutil.rmtree() para eliminar el directorio completo
            try:
                shutil.rmtree(directorioDeviceJson)
                print(f"Se ha eliminado el directorio {directorioDeviceJson}")
            except:
                print(
                    f"Error al eliminar el directorio {directorioDeviceJson}")
        else:
            print(f"El directorio {directorioDeviceJson} no existe")
    
    # Calcular el tiempo transcurrido
    elapsed_time = end_time - start_time
    print(f"Tiempo de envío: {elapsed_time} segundos")

# VERFICIA QUE LA CADENA JSON TENGA EL FORMATO CORRECTO, SI LO TIENE REENVIA

def procesarJson(json_string, direccion_ip):
    try:
        recive_data = json.loads(json_string)
        procesarJsonImagen(recive_data, json_string, direccion_ip)
    except:
        print("Error Json")


def multi_threaded_client(connection):
    connection.send(str.encode('Server is working:'))
    data = ''
    json_string = ''
    while True:
        # data = connection.recv(1000000)

        while True:
            part = connection.recv(BUFF_SIZE).decode('utf-8')
            data += part

            subcadena = re.search(r'\{.*?\}', data)
            if subcadena:
                # print(subcadena.group(0))
                json_string = subcadena.group(0)
                data = data.replace(json_string, '')
                break
            # pprint.pprint(part)
            # if '}' in part:
                # either 0 or end of data
                # print("fin")
                # break
        # now = datetime.now()
        # print(json_string)
        # print("Llega la Imagen " + now.strftime('%Y%m%d%H%M%S'))
        direccion_ip, puerto = connection.getpeername()
        procesarJson(json_string, direccion_ip)
    connection.close()


# pprint.pprint(sockets)
for ServerSideSocket_1 in sockets:
    ServerSideSocket_1.listen(255)
while True:
    readable, writable, exceptional = select.select(sockets, empty, empty)
    for s in readable:
        Client, address = s.accept()
        print('Connected to: ' + address[0] + ':' + str(address[1]))
        start_new_thread(multi_threaded_client, (Client, ))
        ThreadCount += 1
        print('Thread Number: ' + str(ThreadCount))
    """ (client_data, client_address) = s.recvfrom(1024)
        print(client_address, client_data)
        s.sendto(client_data, client_address) """
    # s.sendto(client_data, client_address)
print("sale")
for s in sockets:
    s.close()


