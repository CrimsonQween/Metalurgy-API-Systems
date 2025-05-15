# Users Endpoints

| Method | Endpoint      | Description           |
|--------|---------------|-----------------------|
| POST   | Create User  | Create new user        |
| GET    | Get Users    | List all users         |
| GET    | Get User     | Get single user        |
| PUT    | Update User  | Update user            |
| DELETE | Delete User  | Delete user            |
| POST   | Follow User  | Follow a user          |
| DELETE | Unfollow User| Unfollow a user        |
| GET    | Get Followers| Get user's followers   |
| GET    | Get Following| Get user's following   | 

### Examples

#### Create Users
This endpoint is used to create a user. Needs to be insterted in Body - Raw - JSON Format

**POST /users**
```json
{
    "username": "Lula1234",
    "email": "lulaphillips@gmail.com",
    "password": "weinerdogs1234",
    "firstName": "Lula",
    "lastName": "Phillips",
    "bio": "Slipknot No1 Fan , Freelancer and Coffee Addict",
    "profile_picture": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJaSVbvNS0IgCfc4ASVxykebVp0OBT0x8osw&s",
    "intersts": "painting, metal music",
    "alias": "No1Maggot"
}
```

**Response**
```json
{
  "message": "User created successfully",
}
```
#### Get Users
This endpoint is used to get a list of all users. Requires page and limit queries.

**GET users/getUsers.php?page=1&limit=10**
```json
[
        {
            "id": 1,
            "username": "eddieG",
            "email": "edwardgalea@gmail.com",
            "firstName": "Edward",
            "lastName": "Galea",
            "bio": null,
            "profile_picture": null,
            "interests": null,
            "alias": null
        },
        {
            "id": 3,
            "username": "JPurley",
            "email": "jacobpurley@gmail.com",
            "firstName": "Jacob",
            "lastName": "Purley",
            "bio": null,
            "profile_picture": null,
            "interests": null,
            "alias": null
        },
]
```
#### Get a Single User
This endpoint is used to Get a Single User. Requires the user id.

**GET users/getSingleUser.php?id=1**
```json
{
    "id": 1,
    "username": "eddieG",
    "email": "edwardgalea@gmail.com",
    "firstName": "Edward",
    "lastName": "Galea",
    "alias": null,
    "bio": null,
    "profile_picture": null,
    "interests": null
}
```

or

```json
{
  "message": "User not found",
}
```

#### Update User
This endpoint is used to update a users information. Needs to be inserted into Body - Raw - JSON Format

**PUT users/update.php**
Body:
```json
{
            "id": 18,
            "username": "H.Borg",
            "email": "helen@gmail.com",
            "firstName": "Helen",
            "lastName": "Micallef"
}
```
Response:
```json
{
  "message": "User updated successfully"
}
```
#### Delete User
This endpoint is used to Delet a User from the system. Requires the user id to be inserted into Body - Raw - JSON Format.

**DELETE /users/delete.php**
Body:
```json
{
    "id": 18
 }

```
Response:
```json
{
  "message": "User deleted  successfully"
}
```

#### Follow User
This endpoint is used to follow a user. Requires the user ids of the follower and the followed to be inserted into Body - Raw - JSON

**POST users/followUser.php**
Body:
```json
{
    "follower_id" : 1,
    "followed_id" : 3
}
```
Response:
```json
{
  "message": "Followed successfully"
}
```
#### Unfollow User
This endpoint is used to unfollow a user. Requires the user ids of the follower and the followed to be inserted into Body - Raw - JSON

**DELETE users/UnfollowUser.php**
Body:
```json
{
    "follower_id" : 1,
    "followed_id" : 3
}
```
Response:
```json
{
  "message": "Unfollowed successfully"
}
```
#### Get User Followers
This endpoint is used to get a useras followers. Requires the user id of the follower.

**GET users/getFollowers.php?id=1**
```json
{
    "followers": []
}
```
#### Get Followed 
This endpoint is used to get a users followers. Requires the user id.
**GET users/getFollowing.php?id=1**
```json
{
    "followers": []
}
```