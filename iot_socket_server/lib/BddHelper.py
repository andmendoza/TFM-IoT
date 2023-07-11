class BddHelper:
    def __init__(self, db):
        self.db = db

    def getAsignacionByDevice(self, deviceId):
        collectionAsignacion = self.db['asignacion']
        pipeline = [
            {
                "$lookup": {
                    "from": "device",
                    "localField": "device_id",
                    "foreignField": "_id",
                    "as": "device"
                }
            },
            {
                "$unwind": "$device"
            },
            {
                "$match": {
                    "device.serie": deviceId,
                    "estado": 1
                }
            },
            {
                "$limit": 1
            }
        ]
        cursor_asignacion = collectionAsignacion.aggregate(pipeline)
        record = next(cursor_asignacion, None)
        if record:
            return record
        return None

    def getDevice(self, deviceId):
        collectionDevice = self.db['device']
        cursor_device = collectionDevice.find({"serie": deviceId})
        record = next(cursor_device, None)
        if record:
            return record
        return None

    def getlastnodetectimage(self, deviceId):
        collectionTracking = self.db['tracking']
        pipeline = [
            {"$sort": {"_id": 1}},
            {
                "$lookup": {
                    "from": "asignacion",
                    "localField": "asignacion_id",
                    "foreignField": "_id",
                    "as": "asignacion"
                }
            },
            {"$unwind": "$asignacion"},
            {
                "$lookup": {
                    "from": "device",
                    "localField": "asignacion.device_id",
                    "foreignField": "_id",
                    "as": "asignacion.device"
                }
            },
            {"$unwind": "$asignacion.device"},
            {
                "$lookup": {
                    "from": "empleado",
                    "localField": "asignacion.empleado_id",
                    "foreignField": "_id",
                    "as": "asignacion.empleado"
                }
            },
            {"$unwind": "$asignacion.empleado"},
            {
                "$match": {
                    "asignacion.device.serie": deviceId,
                    "fd": "0"
                }
            },
            {"$limit": 1}
        ]
        cursor_tracking = collectionTracking.aggregate(pipeline)
        record = next(cursor_tracking, None)
        if record:
            return record
        return None
    
    def getlastnodetectimageall(self):
        collectionTracking = self.db['tracking']
        pipeline = [
            {"$sort": {"_id": 1}},
            {
                "$lookup": {
                    "from": "asignacion",
                    "localField": "asignacion_id",
                    "foreignField": "_id",
                    "as": "asignacion"
                }
            },
            {"$unwind": "$asignacion"},
            {
                "$lookup": {
                    "from": "device",
                    "localField": "asignacion.device_id",
                    "foreignField": "_id",
                    "as": "asignacion.device"
                }
            },
            {"$unwind": "$asignacion.device"},
            {
                "$lookup": {
                    "from": "empleado",
                    "localField": "asignacion.empleado_id",
                    "foreignField": "_id",
                    "as": "asignacion.empleado"
                }
            },
            {"$unwind": "$asignacion.empleado"},
            {
                "$match": {
                    "fd": "0"
                }
            },
            {"$limit": 1}
        ]
        cursor_tracking = collectionTracking.aggregate(pipeline)
        record = next(cursor_tracking, None)
        if record:
            return record
        return None

    def addTracking(self, data):
        collectionTracking = self.db['tracking']
        record = collectionTracking.insert_one(data)
        return record.inserted_id

    def updateTrackingFD(self, currentTraking, estado_tracking, persona_tracking, empleado_id_fd):
        collectionTracking = self.db['tracking']
        filtro = {'_id': currentTraking['_id']}
        # Define los campos y los valores que deseas actualizar
        actualizacion = {'$set': {
            'fd': '1', 'estado': estado_tracking, "pesonanombre": persona_tracking, "empleado_id_fd": empleado_id_fd}}
        # Actualiza el documento utilizando update_one
        result = collectionTracking.update_one(filtro, actualizacion)
        return result

    def getEmpleados(self):
        records = self.db['empleado'].find()
        empleados = []
        for doc in records:
            empleados.append(doc)
        return empleados

    def getLastTrackingByAsignacion(self,tracking_id, asignacion_id, limite=10):
        query = {
            '_id': {'$lt': tracking_id},
            'asignacion_id': asignacion_id
        }
        records = self.db['tracking'].find(query).sort('_id', -1).limit(limite)
        tracking = []
        for doc in records:
            tracking.append(doc)
        return tracking
    
    def addNotificacion(self, data):
        collectionNotificacion = self.db['notificaciones']
        record = collectionNotificacion.insert_one(data)
        return record.inserted_id   

