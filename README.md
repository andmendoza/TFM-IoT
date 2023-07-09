DISEÑO E IMPLEMENTACIÓN DE SISTEMA IOT PARA MEJORA DE LA CONDUCCIÓN.

DESIGN AND IMPLEMENTATION OF IOT SYSTEM TO IMPROVE DRIVING

En este trabajo se propone la creación de un sistema IoT que ayude a los usuarios a medir y controlar los niveles de somnolencia en la conducción,
mediante la integración de diferentes tecnologías como el ESP32-CAM que se encarga de capturar imágenes y enviarlas al servidor sockets, el mismo que
envía las imágenes al servidor de inferencia para procesarlas y devolver al servidor de sockets. Los datos procesados son enviados a la base de datos 
de MongoDB para luego ser enviados a la web.

Arquitectura del sistema
![image](https://github.com/andmendoza/TFM-IoT/assets/68863818/a83b0a67-505e-400e-885e-74b9b39c57b7)

Librerías utilizadas
En la raíz del proyecto tenemos un archivo “requirements.txt” con todas las librerías que requiere el proyecto. Luego abrir la ruta del proyecto en un terminal y digitar el siguiente comando para instalar las librerías con el siguiente comando:
python -m pip install -r requirements.txt

1. Algoritmo cargado en la placa ESP32-CAM
   esp32-cam
2. Servidor sockets
   mongodb_iot_onrumbo_wsserver_raid.py
3. Algoritmo de somnolencia
   mongodbfasedetectorsinventanaclass
5. Aplicación WEB
   www_IoT_Somnolencia


