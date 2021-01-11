
### Pangrea Test Subscription Server

- **Start Server On port 8000**

- **Add env file**

### Api Endpoint 
 
- **POST  http://127.0.0.1:8000/api/subscribe ** 
    Send the ["topic"] as a query parameter to the url which in turn make it this way http://127.0.0.1:8000/api/subscribe/{topic}
    
    -create a topic from url and also  subscribe to a topic from this endpoint


- - **POST  http://127.0.0.1/api/subscribers ** 
    Send the ["topic"] as a query parameter to the url which in turn make it this way http://127.0.0.1:8000/api/subscribers/{topic}

    -get list of all susbcribered messages for a particular topic
