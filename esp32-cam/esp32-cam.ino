#include <WebServer.h>
#include <WiFi.h>
#include <esp32cam.h>
#include <base64.h>
#include <WiFiClient.h>
#include <HTTPClient.h>



//Añadir credenciales para la conexion Wifi
const char* WIFI_SSID = "WIFI_SSID";
const char* WIFI_PASS = "WIFI_PASS";

WebServer server(80);  //servidor en el puerto 80

static auto loRes = esp32cam::Resolution::find(320, 240);  //baja resolucion
static auto hiRes = esp32cam::Resolution::find(800, 600);  //alta resolucion

static WiFiClient client;
static WiFiClient clientArray[10];

void serveJpg()  //captura imagen .jpg
{
  auto frame = esp32cam::capture();
  if (frame == nullptr) {
    Serial.println("CAPTURE FAIL");
    server.send(503, "", "");
    return;
  }
  Serial.printf("CAPTURE OK %dx%d %db\n", frame->getWidth(), frame->getHeight(),
                static_cast<int>(frame->size()));

  server.setContentLength(frame->size());
  server.send(200, "image/jpeg");
  WiFiClient client = server.client();
  frame->writeTo(client);  // y envia a un cliente (en este caso sera python)

}

void handleJpgLo()  //permite enviar la resolucion de imagen baja
{
  if (!esp32cam::Camera.changeResolution(loRes)) {
    Serial.println("SET-LO-RES FAIL");
  }
  serveJpg();
}

void handleJpgHi()  //permite enviar la resolucion de imagen alta
{
  if (!esp32cam::Camera.changeResolution(hiRes)) {
    Serial.println("SET-HI-RES FAIL");
  }
  serveJpg();
}



void setup() {
  Serial.begin(115200);
  Serial.println();

  {
    using namespace esp32cam;
    Config cfg;
    cfg.setPins(pins::AiThinker);
    cfg.setResolution(hiRes);
    cfg.setBufferCount(2);
    cfg.setJpeg(80);

    bool ok = Camera.begin(cfg);
    Serial.println(ok ? "CAMARA OK" : "CAMARA FAIL");
  }

  WiFi.persistent(false);
  WiFi.mode(WIFI_STA);
  WiFi.begin(WIFI_SSID, WIFI_PASS);  //nos conectamos a la red wifi
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
  }

  Serial.print("http://");
  Serial.print(WiFi.localIP());
  Serial.println("/cam-lo.jpg");  //para conectarnos IP res baja

  Serial.print("http://");
  Serial.print(WiFi.localIP());
  Serial.println("/cam-hi.jpg");  //para conectarnos IP res alta

  server.on("/cam-lo.jpg", handleJpgLo);  //enviamos al servidor
  server.on("/cam-hi.jpg", handleJpgHi);
}


int secciones = 5;
String partesImagen[5];

void loop() {
  
  String base64_image = getImageBase64();
  Serial.println("-- Obtiene Imagen");
  if (base64_image.length() > 0) {
    unsigned long currentMillis = millis();
    int tamanoSeccion = base64_image.length() / secciones;

    for (int i = 0; i < secciones; i++) {
      //String seccion = base64_image.substring(i * tamanoSeccion, (i + 1) * tamanoSeccion);
      String seccion;
      if (i != (secciones-1)) {
        seccion = base64_image.substring(i * tamanoSeccion, (i + 1) * tamanoSeccion);
      } else {
        seccion = base64_image.substring(i * tamanoSeccion);
      }
      //arduni_es_1 -> nombre dispositivo para ser confgurado en la bbdd
      seccion = "{\"image_id\": \"" + ((String)currentMillis) + "\",\"part\": \"" + ((String)i) + "\",\"device_id\": \"arduni_es_1\",\"image_data\": \"" + seccion + "\"}";
      //socketSendArray(i, 2001 + i, seccion);
      partesImagen[i] = seccion;
      //Serial.println(seccion);
      //Serial.println("Imagen enviada " + ((String)i));
    }
    Serial.println("-- Imagen Segmentada");
    Serial.println("Inciciado socket ->");
    socketSendArray(0, 2001, partesImagen[0]);
    socketSendArray(1, 2002, partesImagen[1]);
    socketSendArray(2, 2003, partesImagen[2]);
    socketSendArray(3, 2004, partesImagen[3]);
    socketSendArray(4, 2005, partesImagen[4]);
    /*socketSendArray(5, 2006, partesImagen[5]);
    socketSendArray(6, 2007, partesImagen[6]);
    socketSendArray(7, 2008, partesImagen[7]);
    socketSendArray(8, 2009, partesImagen[8]);
    socketSendArray(9, 2010, partesImagen[9]);*/
    Serial.println(".....");
    Serial.println("<- Finalizado envio socket");
    Serial.println("");
    //delay(800);
  }
}
//http://192.168.1.160/cam-hi.jpg
//68.183.141.197
//por =2004
const IPAddress serverSocket(192, 168, 1, 135);  // Dirección IP del servidor
const int portSocket = 2004;                      // Puerto del servidor

void socketSendArray(int indice, int puerto, String cadena) {
  //Serial.println("socketSend");   
  if (!clientArray[indice].connected()) {
    if (clientArray[indice].connect(serverSocket, portSocket)) {
      Serial.println("conectado al servidor");
      clientArray[indice].println(cadena);
      //Serial.println("Imagen enviada socket" + ((String)indice));
    } else {
      Serial.println("Error conectar al servidor");
    }
  } else {
    clientArray[indice].println(cadena);
    //Serial.println("Imagen enviada socket" + ((String)indice));
  }
}

String getImageBase64() {
  auto frame = esp32cam::capture();
  if (frame == nullptr) {
    Serial.println("CAPTURE FAIL FROM API SENDER");
    return "";
  } else {
    String base64_image = base64::encode(frame->data(), frame->size());
    return base64_image;
  }
}
