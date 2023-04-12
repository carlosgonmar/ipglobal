# IPGlobal

## Install

- Install Docker and Docker Compose https://docs.docker.com/compose/install/
- Open your console and go to the project folder.
- Run `docker ps` to make sure you don't have anything under port 8888.
- Run `docker stop $(docker ps -a -q)` to stop all the containers if you need it.
- Execute `docker-compose up -d`
- Now you can use Postman collection: IPGlobal.postman_collection.json
- You can access to http://localhost:8888 to check the webview.

## Testing

- Open your console
- Execute `docker exec -it ipglobal_cgm bash`
- Inside the docker container, execute `php vendor/bin/phpunit`

## Analisys

- Open your console
- Execute `docker exec -it ipglobal_cgm bash`
- Inside the docker container, execute `php vendor/bin/phpstan analyse src`

## Documentation
List of web routes
- Posts:
    - All
        - Description: Show all posts.
        - URL: [GET] http://localhost:8888
    - Show
        - Description: Show specific post.
        - URL: [GET] http://localhost:8888/posts/{id}
      
List of api routes
- Posts:
    - All
        - Description: Return the entire list of the posts.
        - URL: [GET] http://localhost:8888/api/posts
        - Parameters: empty
    - Show
        - Description: Return a post.
        - URL: [GET] http://localhost:8888/api/posts/{id}
        - Parameters: empty
    - Store
        - Description: Create a new task.
        - URL: [POST] http://localhost:8888/api/posts
        - Parameters:
            - title (string) max 255cc
            - body (string)
            - userID (integer)
- Users:
    - All
        - Description: Return the entire list of the users.
        - URL: [GET] http://localhost:8888/api/users
        - Parameters: empty
    - Show
        - Description: Return a user.
        - URL: [GET] http://localhost:8888/api/users/{id}
        - Parameters: empty
