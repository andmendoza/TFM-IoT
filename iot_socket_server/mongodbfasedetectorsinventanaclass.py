from lib.BddHelper import BddHelper
import cv2
import math
import numpy as np
import dlib
import imutils
from imutils import face_utils
from matplotlib import pyplot as plt
# import vlc
import train as train
import sys
import webbrowser
import datetime
import face_recognition
import urllib.request  # para abrir y leer URL
from PIL import Image
import sys
import time
from pprint import pprint
from pymongo import MongoClient
import http.client
import ssl 
import base64
import urllib.parse


client = MongoClient('localhost', 27017)
db = client['iotonrumbo']
bddhelper = BddHelper(db)


# Load a sample picture and learn how to recognize it.
""" obama_image = face_recognition.load_image_file("rostros/obama.jpeg")
obama_face_encoding = face_recognition.face_encodings(obama_image)[0] """

# Load a second sample picture and learn how to recognize it.
""" biden_image = face_recognition.load_image_file("rostros/luis.png")
biden_face_encoding = face_recognition.face_encodings(biden_image)[0] """

""" andres_image = face_recognition.load_image_file("rostros/andres.png")
andres_face_encoding = face_recognition.face_encodings(andres_image)[0] """

# Create arrays of known face encodings and their names
""" known_face_encodings = [
    obama_face_encoding,
    biden_face_encoding,
    andres_face_encoding
]
known_face_names = [
    "Barack Obama",
    "Luis",
    "Andres Mendoza"
] """
known_face_encodings =[]
known_face_names = []
empleados = bddhelper.getEmpleados()

for rowEmpleado in empleados:
    #print(rowEmpleado)
    local_image = face_recognition.load_image_file(rowEmpleado['imagen'])
    local_image_encoding = face_recognition.face_encodings(local_image)[0] 
    known_face_encodings.append(local_image_encoding)
    #known_face_names.append(f"{rowEmpleado['nombres']} {rowEmpleado['apellidos']}")
    known_face_names.append(rowEmpleado)
#print(known_face_encodings)
#print(known_face_names)
# Initialize some variables
face_locations = []
face_encodings = []
face_names = []
process_this_frame = True


def yawn(mouth):
    return ((euclideanDist(mouth[2], mouth[10])+euclideanDist(mouth[4], mouth[8]))/(2*euclideanDist(mouth[0], mouth[6])))


def getFaceDirection(shape, size):
    image_points = np.array([
        shape[33],    # Nose tip
        shape[8],     # Chin
        shape[45],    # Left eye left corner
        shape[36],    # Right eye right corne
        shape[54],    # Left Mouth corner
        shape[48]     # Right mouth corner
    ], dtype="double")

    # 3D model points.
    model_points = np.array([
        (0.0, 0.0, 0.0),             # Nose tip
        (0.0, -330.0, -65.0),        # Chin
        # Left eye left corner
        (-225.0, 170.0, -135.0),
        # Right eye right corne
        (225.0, 170.0, -135.0),
        # Left Mouth corner
        (-150.0, -150.0, -125.0),
        # Right mouth corner
        (150.0, -150.0, -125.0)

    ])

    # Camera internals

    focal_length = size[1]
    center = (size[1]/2, size[0]/2)
    camera_matrix = np.array(
        [[focal_length, 0, center[0]],
         [0, focal_length, center[1]],
         [0, 0, 1]], dtype="double"
    )
    dist_coeffs = np.zeros((4, 1))  # Assuming no lens distortion
    (success, rotation_vector, translation_vector) = cv2.solvePnP(model_points,
                                                                  image_points, camera_matrix, dist_coeffs, flags=cv2.SOLVEPNP_ITERATIVE)
    return (translation_vector[1][0])


def euclideanDist(a, b):
    return (math.sqrt(math.pow(a[0]-b[0], 2)+math.pow(a[1]-b[1], 2)))

# EAR -> Eye Aspect ratio


def ear(eye):
    return ((euclideanDist(eye[1], eye[5])+euclideanDist(eye[2], eye[4]))/(2*euclideanDist(eye[0], eye[3])))


def writeEyes(a, b, img):
    y1 = max(a[1][1], a[2][1])
    y2 = min(a[4][1], a[5][1])
    x1 = a[0][0]
    x2 = a[3][0]
    cv2.imwrite('left-eye.jpg', img[y1:y2, x1:x2])
    y1 = max(b[1][1], b[2][1])
    y2 = min(b[4][1], b[5][1])
    x1 = b[0][0]
    x2 = b[3][0]
    cv2.imwrite('right-eye.jpg', img[y1:y2, x1:x2])
# open_avg = train.getAvg()
# close_avg = train.getAvg()

# alert = vlc.MediaPlayer('focus.mp3')


frame_thresh_1 = 15
frame_thresh_2 = 10
frame_thresh_3 = 5

close_thresh = 0.3  # (close_avg+open_avg)/2.0
flag = 0
yawn_countdown = 0
map_counter = 0
map_flag = 1

# print(close_thresh)

avgEAR = 0
detector = dlib.get_frontal_face_detector()
predictor = dlib.shape_predictor('shape_predictor_68_face_landmarks.dat')
(leStart, leEnd) = face_utils.FACIAL_LANDMARKS_IDXS["left_eye"]
(reStart, reEnd) = face_utils.FACIAL_LANDMARKS_IDXS["right_eye"]
(mStart, mEnd) = face_utils.FACIAL_LANDMARKS_IDXS["mouth"]

directorioBase = "C:/tem/16-06-2023/iot_socket_server/images/"

while (True):

    
    currentTraking = bddhelper.getlastnodetectimage('arduni_ec_1')

    if currentTraking:
        estado_tracking = "SINESTADO"
        persona_tracking = "SINPERSONA"
        empleado_id_fd = None

        # imgResponse = urllib.request.urlopen (url) #abrimos el URL
        # imgNp = np.array(bytearray(imgResponse.read()),dtype=np.uint8)
        pprint(currentTraking)
        pathImage = f"{directorioBase}{currentTraking['basepath']}{currentTraking['imagename']}"
        pathImageFd = f"{directorioBase}{currentTraking['basepath']}fd/{currentTraking['imagename']}"
        pathImageLastFd = f"{directorioBase}{currentTraking['asignacion']['device']['serie']}/remote_image_last_fd.jpg"
        #print(pathImage)

        # imgResponse = Image.open(pathImage)
        # imgResponse.load()
        # image_cv2 = cv2.imread(pathImage)
        # print(image_cv2)
        # imgNp = np.array(image_cv2,dtype=np.uint8)
        # imgNp = imgNp.astype(np.uint8)
        # print(imgNp)
        # img = cv2.imdecode(imgNp, -1)  # decodificamos
        # img = cv2.rotate(img, cv2.ROTATE_90_CLOCKWISE) # vertical

        with open(pathImage, "rb") as image:
            f = image.read()
            # convert to numpy array
            imgNp = np.asarray(bytearray(f))

            # RGB to Grayscale
            img = cv2.imdecode(imgNp, -1)

        size = img.shape
        rects = detector(img, 0)
        gray = img

        # ret, frame = capture.read()
        # size = frame.shape
        # gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
        # gray = frame
        # rects = detector(gray, 0)
        inicio_fd = time.time()
        if process_this_frame:

            if (len(rects)):

                # Resize frame of video to 1/4 size for faster face recognition processing
                small_frame = cv2.resize(img, (0, 0), fx=0.25, fy=0.25)

                # Convert the image from BGR color (which OpenCV uses) to RGB color (which face_recognition uses)
                rgb_small_frame = small_frame[:, :, ::-1]

                # Find all the faces and face encodings in the current frame of video
                face_locations = face_recognition.face_locations(
                    rgb_small_frame)
                face_encodings = face_recognition.face_encodings(
                    rgb_small_frame, face_locations)
                face_names = []

                shape = face_utils.shape_to_np(predictor(gray, rects[0]))
                leftEye = shape[leStart:leEnd]
                rightEye = shape[reStart:reEnd]
                leftEyeHull = cv2.convexHull(leftEye)
                rightEyeHull = cv2.convexHull(rightEye)
                # print("Mouth Open Ratio", yawn(shape[mStart:mEnd]))
                leftEAR = ear(leftEye)  # Get the left eye aspect ratio
                rightEAR = ear(rightEye)  # Get the right eye aspect ratio
                avgEAR = (leftEAR+rightEAR)/2.0
                eyeContourColor = (255, 255, 255)

                face_names = []
                
                for face_encoding in face_encodings:
                    # See if the face is a match for the known face(s)
                    matches = face_recognition.compare_faces(
                        known_face_encodings, face_encoding)
                    persona_tracking = "DESCONOCIDO"
                    name = persona_tracking

                    face_distances = face_recognition.face_distance(
                        known_face_encodings, face_encoding)
                    best_match_index = np.argmin(face_distances)
                    if matches[best_match_index]:
                        persona_tracking = known_face_names[best_match_index]['nombres'] + ' ' + known_face_names[best_match_index]['apellidos']
                        empleado_id_fd = known_face_names[best_match_index]['_id']
                        name = persona_tracking

                    face_names.append(name)

                    if (yawn(shape[mStart:mEnd]) > 0.6):
                        estado_tracking = "BOSTEZO DETECTADO"
                        cv2.putText(gray, estado_tracking, (50, 50),
                                    cv2.FONT_HERSHEY_COMPLEX, 1, (0, 255, 127), 2)
                        yawn_countdown = 1
                        # sendMQTT("Awn Detected/1", "awn Detected")

                    if (avgEAR < close_thresh):
                        flag += 1
                        eyeContourColor = (0, 255, 255)
                        pprint(flag)
                        if (yawn_countdown and flag >= frame_thresh_3):
                            eyeContourColor = (147, 20, 255)
                            estado_tracking = "SOMNOLENCIA DESPUES DEL BOSTEZO"
                            cv2.putText(gray, estado_tracking, (50, 50),
                                        cv2.FONT_HERSHEY_COMPLEX, 1, (0, 255, 127), 2)
                            # alert.play()
                            # sendMQTT("SOMNOLENCIA DESPUES DEL BOSTEZO/2", "SOMNOLENCIA DESPUES DEL BOSTEZO")
                            if (map_flag):
                                map_flag = 0
                                map_counter += 1
                        elif (flag >= frame_thresh_2 and getFaceDirection(shape, size) < 0):
                            eyeContourColor = (255, 0, 0)
                            estado_tracking = "SOMNOLENCIA (POSTURA DEL CUERPO)"
                            cv2.putText(gray, estado_tracking, (50, 50),
                                        cv2.FONT_HERSHEY_COMPLEX, 1, (0, 255, 127), 2)
                            # alert.play()
                            # sendMQTT("SOMNOLENCIA (POSTURA DEL CUERPO)/3", "SOMNOLENCIA (POSTURA DEL CUERPO)")
                            if (map_flag):
                                map_flag = 0
                                map_counter += 1
                        elif (flag >= frame_thresh_1):
                            eyeContourColor = (0, 0, 255)
                            estado_tracking = "SOMNOLIENTA (NORMAL)"
                            cv2.putText(gray, estado_tracking, (50, 50),
                                        cv2.FONT_HERSHEY_COMPLEX, 1, (0, 255, 127), 2)
                            # alert.play()
                            # sendMQTT("SOMNOLIENTA (NORMAL)/4","SOMNOLIENTA (NORMAL)")
                            if (map_flag):
                                map_flag = 0
                                map_counter += 1
                    elif (avgEAR > close_thresh and flag):
                        print("Flag reseted to 0")
                        # sendMQTT("Flag reseted to 0/5","Flag reseted to 0")
                        # alert.stop()
                        yawn_countdown = 0
                        map_flag = 1
                        flag = 0

                if (map_counter >= 3):
                    map_flag = 1
                    map_counter = 0
                    # vlc.MediaPlayer('take_a_break.mp3').play()
                    #webbrowser.open(
                    #    "https://www.google.com/maps/search/hotels+or+motels+near+me")
                    # sendMQTT("Descanso/7","Hotel cercano")

                cv2.drawContours(gray, [leftEyeHull], -1, eyeContourColor, 2)
                cv2.drawContours(gray, [rightEyeHull], -1, eyeContourColor, 2)
                writeEyes(leftEye, rightEye, img)
            if (avgEAR > close_thresh):
                # alert.stop()
                pass
        process_this_frame = not process_this_frame

        # Display the results
        for (top, right, bottom, left), name in zip(face_locations, face_names):
            # Scale back up face locations since the frame we detected in was scaled to 1/4 size
            top *= 4
            right *= 4
            bottom *= 4
            left *= 4

            # Draw a box around the face
            cv2.rectangle(img, (left, top), (right, bottom), (125, 125, 0), 2)

            # Draw a label with a name below the face
            cv2.rectangle(img, (left, bottom - 35),
                          (right, bottom), (0, 0, 255), cv2.FILLED)
            font = cv2.FONT_HERSHEY_DUPLEX
            cv2.putText(img, name, (left + 6, bottom - 6),
                        font, 1.0, (255, 255, 255), 1)

        # cv2.imshow('Driver', gray)

        cv2.imwrite(pathImageFd, img)
        cv2.imwrite(pathImageLastFd, img)
        fin_fd = time.time()
        diff_in_milli_secs = fin_fd - inicio_fd
        
        #filtro = {'_id': currentTraking['_id']}
        # Define los campos y los valores que deseas actualizar
        #actualizacion = {'$set': {'fd': '1'}}
        # Actualiza el documento utilizando update_one
        result = bddhelper.updateTrackingFD(currentTraking,estado_tracking,persona_tracking,empleado_id_fd,diff_in_milli_secs)
        if persona_tracking!= 'SINPERSONA'  and estado_tracking != "SINESTADO":
            last_trackings = bddhelper.getLastTrackingByAsignacion(currentTraking['_id'],currentTraking['asignacion_id'], 5)
            if len(last_trackings) > 1:
                contadorEstados = 0
                for localTracking in last_trackings:
                    if localTracking['estado'] != "SINESTADO":
                        contadorEstados = contadorEstados + 1
                #crear notificacion
                if contadorEstados>=2:
                    bddhelper.addNotificacion({
                        'tracking_id': currentTraking['_id'],
                        'last_trackings': last_trackings
                    })
                    #enviando notificacionb
                    conn = http.client.HTTPSConnection("api.ultramsg.com",context = ssl._create_unverified_context())
                    with open(pathImageLastFd, "rb") as image_file:
                        encoded_string = base64.b64encode(image_file.read())

                    img_bas64=urllib.parse.quote_plus(encoded_string)
                    payload = "token=wydkqvhbkim4i2fw&to="+currentTraking['cliente'][0]['telefono']+"&image="+ img_bas64 + "&caption=OnRumbo Iot Alertas: Hay una alerta de empleado con sueño, Empleado: " + persona_tracking + " - " + estado_tracking
                    payload = payload.encode('utf8').decode('iso-8859-1') 

                    headers = { 'content-type': "application/x-www-form-urlencoded" }

                    #conn.request("POST", "/instance51743/messages/chat", payload, headers)
                    conn.request("POST", "/instance51743/messages/image", payload, headers)

                    res = conn.getresponse()
                    data = res.read()

                    print(data.decode("utf-8"))

        if (cv2.waitKey(1) == 27):
            break


