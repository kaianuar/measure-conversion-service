# Measurement API

This API was built to be both scalable and future proof. I've also made use of Lumen as it's lightweight enough to avoid the app from being bloated while having just the right amount of functionalities without having to reinvent the wheels. Although right now it only calculates the total of 2 distances, the architecture makes use of design patterns that allows for additional functionalities to be easily added. It makes as much as possible SOLID and DRY principles in order to minimise duplication of code. 

However this might open up the possibility of over-engineering, for example the DistanceClass. Instead of just implementing the interface directly I extended the MeasurementAbstractClass which does the implementation. My thought process for this is so that if there was a need to create a AreaClass or other types of measurements, it could extend the same MeasurementAbstractClass conversion trait or any other traits that the abstract class eventually uses.

I also approached it making sure there was a decent amount of unit test coverage. At this point of time though I have only included unit test for the class and not for API responses. Testing the endpoints would definitely something that needs to be added later on.

To run the application, clone the repo to the server root and run `composer install`. The web service should be accesible from the `/v1/distance/total` endpoint.

A sample JSON request payload would be something like this:

```json
{
    "outputType": "meter",
    "data": 
        [
            {
                "unit": 3,
                "uom": "yard"
            },
            {
                "unit": 5,
                "uom": "meter"
            }
        ]
}
```

The successful response payload will look like the following

```json
{
    "status": 200,
    "data": {
        "uom": "meter",
        "total": 7.7432
    }
}
```

Any errors from the api will be returned with the following data structure

```json
{
    "status": 400,
    "data": {
        "error": "output type needs to be either in yard or in meter"
    }
}
```