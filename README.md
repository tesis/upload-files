# API to store images or videos

## Requirements

> Create an endpoint to post an image or a video.

> Image or video should be saved into the folder and saved into a database.

> Additionally add title and description.

> API should return the response with file type, size and path to the file.

> Endpoint should not be public, i.e. provide a basic authentication (tokenized) or provide a solution that would be from your perspective the most optimal.

> Provide the structure of the request and any other information needed for test.

> Add unit testings.

## First thoughts

- provide API folder for the project (personally I prefer to use API folder for controllers, models, traits instead of Http folder as I think this would best suite web applications then restful apps)

- user will register and will be able to upload video or image

- each user might have many images/videos: upload images to the user's folder (scalability)

- uploaded images might have subfolders thumbnails, original, size1, size1, ...: provide subfolders for thumbnails (I personaly use folder for most needed sizes in the application to provide better performance on frontend: browser doesn't need to resize images on the fly )

- what if user will have many files with the same name? rename like image1, image2, or image should have random name, or decline to upload file with same name: in this case - prompt the user to change filename?

- saving file with user id: what if user will upload many images - not convenient

- restrict size of the image/video and change php.ini accordingly (usually default settings are not enough)

- provide size restriction by server (change php.ini) and by application itself, which should also differ file sizes acording to the type of the uploaded file (images will of smaller size then the video)

Change php.ini: 

```ini
post_max_size = 6G
upload_max_filesize = 4G
memory_limit = 8G / -1
```

## Project stack

- Laravel 10
- Database: sqlite (should be enough for test project)
- PHPUnit tests
- Authentication: use sanctum (for basic authentication, sanctum is a good solution, for the network applications or other more complex applications, I prefer passport)

## Final Flow

- a user can register and register endpoint returns token (but could be anything - some data, user could be prompted to verify email, etc)
- newly registered user can login and the response is a token, which is then used for next endpoints that requires authentication
- user can upload image or video: as this is only one input fields, check the mimetype of the uploaded file and restrict the mimetypes for images/videos and response consists of user id, title, description, file name, type, size and path of the file uploaded

## Some additional thoughts

Controllers are saved in app/API folder. I decided to use this structure to be explicit regarding usage of the application files. There are also services. All other classes are saved in Laravel's predefined architecture (Resoruces, Requests, Models). 

Controllers might be saved also in HTTP folder having namespace like app\Http\Api.

## Tests

There are provided PHPUnit tests, including functionalities, ie - login, register, upload image/video. Usually I test also relationships, but here we don't have some significant ones

There are also tests in Postman provided.

