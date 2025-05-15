# Songs Endpoints

| Method | Endpoint                   | Description                |
|--------|----------------------------|----------------------------|
| POST   | Add Songs                  | Add a new song             |
| GET    | Read All Songs             | Read all songs             |
| GET    | Get By Album               | Get songs by album         |
| DELETE | Delete Song                | Delete a song              |
| POST   | Attach Genre               | Attach genre to song       |
| GET    | Filter                     | Filter songs by genre      |

### Example

**POST /songs**
```json
{
  "title": "Battery",
  "album_id": 1,
  "band_id": 1,
  "duration": "5:12",
  "spotify_id": "xyz123",
  "track_number": 1
}
```

**Response**
```json
{
  "message": "Song added successfully"
}
```
**GET api\songs\getAll.php**
```json
[
    {
        "id": 3,
        "title": "XIX",
        "duration": 190146,
        "spotify_id": "5MlsjZyOq3FDBWC3Jsys9N",
        "album_id": 57,
        "track_number": 1,
        "spotify_url": "https://open.spotify.com/track/5MlsjZyOq3FDBWC3Jsys9N"
    },
    {
        "id": 4,
        "title": "Sarcastrophe",
        "duration": 306080,
        "spotify_id": "7b96P5WRVoixTmssXpFL9N",
        "album_id": 57,
        "track_number": 2,
        "spotify_url": "https://open.spotify.com/track/7b96P5WRVoixTmssXpFL9N"
    },
]
```

**GET api/songs/songsByAlbum.php?album_id=97**
```json
[
   {
        "id": 59,
        "title": "Holy Wars...The Punishment Due - Live 1994",
        "duration": 394338,
        "spotify_id": "1dWjx0niJeC6XnidInfMQO",
        "album_id": 97,
        "track_number": 1,
        "spotify_url": "https://open.spotify.com/track/1dWjx0niJeC6XnidInfMQO"
    },
    {
        "id": 60,
        "title": "Reckoning Day - Live 1994",
        "duration": 255158,
        "spotify_id": "0kPji1yfoAs7yyOihf3pKB",
        "album_id": 97,
        "track_number": 2,
        "spotify_url": "https://open.spotify.com/track/0kPji1yfoAs7yyOihf3pKB"
    },
]
```

**DELETE api/songs/delete.php**
Body:
```json
{
  "id": 2
}
```
Response:
```json
{
  "message": "Song deleted successfully"
}
```

**POST api\songs\attachGenre.php**
Body:
```json
{
  "song_id": 3,
  "genre_id": 1
}
```
Response:
```json
{
  "message": "Genre attached successfully"
}
```
**GET songs/filter.php?band_id=10**
```json
[
    {
        "id": 59,
        "album_id": 97,
        "band_id": 10,
        "title": "Holy Wars...The Punishment Due - Live 1994",
        "duration": 394338,
        "spotify_id": "1dWjx0niJeC6XnidInfMQO",
        "track_number": 1,
        "spotify_url": "https://open.spotify.com/track/1dWjx0niJeC6XnidInfMQO",
        "genre_id": null
    },
]
```