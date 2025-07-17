# New World Cargo API Documentation

**Base URL:**
```
https://app.newworldcargo.com/api/
```

---

## 1. Consignment & Parcels Sync

### Get Consignment with Parcels
**GET** `/consignments/{consignment_id}`

Returns consignment info and all parcels/shipments under it.

**Example:**
```
GET https://app.newworldcargo.com/api/consignments/1
```

---

### Get Parcel by Tracking Number
**GET** `/parcels/{tracking_number}`

Returns details for a single shipment/parcel.

**Example:**
```
GET https://app.newworldcargo.com/api/parcels/TRACK123
```

---

### Get Parcels by Status
**GET** `/parcels/status/{status}`

Returns all shipments/parcels filtered by logistics status (status_id).

**Example:**
```
GET https://app.newworldcargo.com/api/parcels/status/7
```

---

### Get Parcels Updated Since
**GET** `/parcels/updated-since?timestamp=YYYY-MM-DDTHH:mm:ssZ`

Returns all shipments/parcels updated since the given timestamp.

**Example:**
```
GET https://app.newworldcargo.com/api/parcels/updated-since?timestamp=2024-06-01T00:00:00Z
```

---

## 2. Parcel Receipt & Dispatch Confirmations

### Parcel Received Confirmation
**POST** `/parcels/received-confirmation`

**Payload:**
```
{
  "consignment_id": 1,
  "tracking_numbers": ["TRACK123", "TRACK456"],
  "received_at": "2024-06-10T12:00:00Z",
  "condition": "Good"
}
```

---

### Parcel Dispatch Confirmation
**POST** `/parcels/dispatch-confirmation`

**Payload:**
```
{
  "tracking_numbers": ["TRACK123", "TRACK456"],
  "dispatch_time": "2024-06-10T15:00:00Z",
  "next_destination": "Lusaka",
  "dispatched_by": "John Doe"
}
```

---

## 3. Invoicing & Customer Reference

### Get Invoice by Tracking Number
**GET** `/invoices/{tracking_number}`

Returns invoice for a parcel.

**Example:**
```
GET https://app.newworldcargo.com/api/invoices/TRACK123
```

---

### Get Customer by ID
**GET** `/customers/{customer_id}`

Returns customer details.

**Example:**
```
GET https://app.newworldcargo.com/api/customers/5
```

---

## 4. Issue Flagging

### Flag Parcel
**POST** `/parcels/flag`

**Payload:**
```
{
  "tracking_number": "TRACK123",
  "reason": "damaged",
  "notes": "Box was crushed"
}
```

---

## 5. Reconciliation

### Reconcile Scanned Parcels
**POST** `/reconcile`

**Payload:**
```
{
  "consignment_id": 1,
  "scanned_tracking_numbers": ["TRACK123", "TRACK456"]
}
```

**Response:**
```
{
  "matched": ["TRACK123"],
  "missing": ["TRACK789"],
  "extras": ["TRACK456"]
}
```

---

## 6. Admin Dashboards / Bulk Sync

### Get Latest Consignment
**GET** `/consignments/latest`

Returns the latest consignment and its parcels.

**Example:**
```
GET https://app.newworldcargo.com/api/consignments/latest
```

---

### Get Unsynced Parcels
**GET** `/parcels/unsynced`

Returns parcels that have not yet been acknowledged by the warehouse.

**Example:**
```
GET https://app.newworldcargo.com/api/parcels/unsynced
```

---

## Notes
- All endpoints return JSON.
- For POST endpoints, use `Content-Type: application/json`.
- Status codes: 200 for success, 400 for validation errors, 404 for not found.
- For more details on each field, refer to the API responses or contact the backend team. 