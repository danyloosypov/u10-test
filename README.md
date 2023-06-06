## About Solution

There are two branches. The first is a simple solution with one controller. The second is a "Strategy-solution" using classes and interface, which provides for scaling the project, where a separate class-service is provided for each courier service.
In DeliveryController we send all the data that concerns the parcel and the customer, and in a separate class-service we determine what data we should send to the courier service.
