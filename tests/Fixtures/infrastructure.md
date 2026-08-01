<!-- next: web-1 -->
---
type: host
name: web-1
status: up
---
Primary application server.

<!-- next: db-1 -->
---
type: host
name: db-1
status: up
---
Primary database server.

<!-- next: web-service -->
---
type: service
name: web-service
status: up
runs_on: [web-1]
depends_on: [db-service]
---
Handles incoming HTTP traffic.

<!-- next: db-service -->
---
type: service
name: db-service
status: up
runs_on: [db-1]
---
Owns the primary datastore.

<!-- next: storefront -->
---
type: application
name: storefront
status: up
composed_of: [web-service, db-service]
---
Customer-facing application, composed of the services above.
