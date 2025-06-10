# Laravel Dog API Test

This project was completed as part of a technical test. It demonstrates integration with an external API, custom command creation, resourceful endpoints, and polymorphic relationships using Laravel 12.

---

## ✅ What’s Included

### 🔁 Command: `app:populate-breeds`
- Fetches all breeds from the [Dog CEO API](https://dog.ceo).
- Creates new breeds if they don’t exist.
- Updates timestamps for existing breeds.
- Removes any breeds no longer returned by the API (based on timestamps).

### 🌐 API Endpoints

| Method | Endpoint                          | Controller / Action              | Description                          |
|--------|-----------------------------------|----------------------------------|--------------------------------------|
| GET    | `/api/breeds`                    | `BreedController@index`          | Return all breeds                    |
| GET    | `/api/breeds/random`             | `BreedController@random`         | Return a random breed                |
| GET    | `/api/breeds/{breed}`            | `BreedController@show`           | Return a specific breed              |
| GET    | `/api/breeds/{breed}/image`      | `BreedController@getBreedImage`  | Return an image for a specific breed |
| POST   | `/api/parks/{park}/breeds`       | `ParkBreedController@store`      | Link a breed to a park               |
| POST   | `/api/users/{user}/breeds`       | `UserBreedController@store`      | Link a breed to a user               |
| POST   | `/api/users/{user}/parks`        | `UserParkController@store`       | Link a park to a user                |


### ⚙️ Service
- `DogApi` service class handles communication with the external Dog CEO API using Laravel’s HTTP client.

### 📦 Resources
- API responses are wrapped using Laravel Resource classes to format the output consistently.

---

## 📝 Notes

- The code is commented throughout to explain assumptions or limitations.
- Since the external Dog API is rate-limited, introducing caching for those requests would help reduce unnecessary calls and improve performance.
- Additionally, API responses within this Laravel app could be cached to enhance efficiency and scalability in future optimizations.


---

## 🌱 Environment

Add the following to your `.env` file:

```env
APP_URL=http://dog_api_test.test
```