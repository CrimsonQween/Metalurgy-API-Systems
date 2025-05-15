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

**DELETE users/UNfollowUser.php**
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

**GET users/getFollowers.php?id=1**
```json
{
    "followers": []
}
```

**GET users/getFollowing.php?id=1**
```json
{
    "followers": []
}
```