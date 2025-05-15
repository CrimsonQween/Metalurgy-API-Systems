# Albums Endpoints

| Method | Endpoint                       | Description                   |
|--------|--------------------------------|-------------------------------|
| GET    | Get All Albums                 | Get all albums                |
| GET    | Get Single Album               | Get single album              |
| GET    | Get Album By Band              | Get albums by band            |
| PUT    | Update Album                   | Update album                  |
| DELETE | Delete Album                   | Delete album                  |

### Example

**GET \albums/getAll.php**
```json
{
  "id": 1,
  "title": "Master of Puppets",
  "release_year": 1986,
  "band": "Metallica"
}
```

**GET /albums/getSingle.php?id=43**
```json
{
    "id": 43,
    "title": "Wake Up The Wicked (Deluxe Version)",
    "spotify_id": "41XrkRQLSBThNGddZTKxiN",
    "release_year": 2024,
    "band_id": 4,
    "cover_image": "https://i.scdn.co/image/ab67616d0000b2731da917a7644a612066ca25f5",
    "spotify_url": "https://open.spotify.com/album/41XrkRQLSBThNGddZTKxiN",
    "track_count": 33
}
```

**GET albums/albumByBand.php?band_id=10**
```json
    {
        "id": 97,
        "title": "Spilling Blood (Live)",
        "spotify_id": "614KfXjjaQ7HOVAAIV89Sn",
        "release_year": 2024,
        "band_id": 10,
        "cover_image": "https://i.scdn.co/image/ab67616d0000b2738dc85107b172fd09fced8dc1",
        "spotify_url": "https://open.spotify.com/album/614KfXjjaQ7HOVAAIV89Sn",
        "track_count": null
    }....
```

**PUT api\albums/update.php**
Body:
```json
 {
        "id": 2,
        "title": ".5: The Gray Chapter (Special Edition)",
        "spotify_id": "0ApKaazNHf0gzjAYZauexq",
        "release_year": 2014,
        "band_id": 2,
        "cover_image": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTw470ew9g7whC5y9bFM6KD2Cm_f07zkj67uQ&s"
    }
```
Response:
```json
{
  "message": "Album updated successfully"
}
```

**DELETE api\albums/delete.php**
Body:
```json
{
  "id": 2
}
```
Response:
```json
{
  "message": "Album deleted successfully"
}
```

