# Bands Endpoints

| Method | Endpoint                 | Description                |
|--------|--------------------------|----------------------------|
| POST   | Creat Band               | Create a new band          |
| GET    | Get Bands                | List all bands             |
| GET    | Get Single Band          | Get single band            |
| PUT    | Update Band              | Update band                |
| DELETE | Delete Band              | Delete band                |
| POST   | Attach Genre             | Attach genre to band       |
| GET    | Search By Name           | Search bands by name       |
| GET    | Filter By Genre          | Filter bands by genre      |

### Example

**POST api\bands\create.php**
Body:
```json
{
    "name": "Slipknot",
    "origin": "USA",
    "year_formed": 1995,
    "spotify_id": "05fG473iIaoy82BF1aGhL8",
    "image_url": "https://pbs.twimg.com/profile_images/1734134159050997760/yvzguO2D_400x400.jpg"
}
```
Response:
```json
{
  "message": "Band created successfully"
}
```

**GET api\bands\read.php**
```json
[
  {
    "id": 1,
    "name": "Metallica",
    "genre": "Heavy Metal"
  }
]
```

**GET /bands/read_single.php?id=6**
```json
[
  {
    "id": 1,
    "name": "Metallica",
    "genre": "Heavy Metal"
  }
]
```

**PUT api/bands/update.php**
Body:
```json
{
    "id": 1,
    "name": "Updated Metallica",
    "origin": "USA",
    "year_formed": 1981,
    "spotify_id": "2ye2Wgw4gimLv2eAKyk1NB",
    "image_url": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSVJ1GfN5K1yhRYR9Pb7Z_tYlnty3jUQSnOOQ&s"
}

```
Response:
```json
{
  "message": "Band updated successfully"
}
```

**DELETE api/bands/delete.php**
Body:
```json
{
    "id": 1
}

```
Response:
```json
{
  "message": "Band deleted successfully"
}
```

**POST api/bands/attachGenre.php**
Body:
```json
{
  "band_id": 1,
  "genre_id": 1
}

```
Response:
```json
{
  "message": "Genre linked successfully"
}
```

**GET bands/search.php?name=Metallica**
```json
[
    {
        "id": 3,
        "name": "Metallica",
        "origin": null,
        "year_formed": null,
        "spotify_id": "2ye2Wgw4gimLv2eAKyk1NB",
        "image_url": "https://i.scdn.co/image/ab6761610000e5eb69ca98dd3083f1082d740e44",
        "genres": "metal, thrash metal, rock, heavy metal, hard rock",
        "followers": 30520454,
        "popularity": 84,
        "spotify_url": "https://open.spotify.com/artist/2ye2Wgw4gimLv2eAKyk1NB"
    }
]
```

**GET /filter.php?genre_id=53**
```json
[
    {
        "id": 3,
        "name": "Metallica",
        "origin": null,
        "year_formed": null,
        "spotify_id": "2ye2Wgw4gimLv2eAKyk1NB",
        "image_url": "https://i.scdn.co/image/ab6761610000e5eb69ca98dd3083f1082d740e44",
        "genres": "metal, thrash metal, rock, heavy metal, hard rock",
        "followers": 30520454,
        "popularity": 84,
        "spotify_url": "https://open.spotify.com/artist/2ye2Wgw4gimLv2eAKyk1NB"
    },
    {
        "id": 4,
        "name": "Powerwolf",
        "origin": null,
        "year_formed": null,
        "spotify_id": "5HFkc3t0HYETL4JeEbDB1v",
        "image_url": "https://i.scdn.co/image/ab6761610000e5ebfa98bd6af388ecfe167efbd8",
        "genres": "power metal, metal, symphonic metal, melodic metal, folk metal, pirate metal, medieval metal, heavy metal",
        "followers": 1007488,
        "popularity": 64,
        "spotify_url": "https://open.spotify.com/artist/5HFkc3t0HYETL4JeEbDB1v"
    },
    {
        "id": 5,
        "name": "Slipknot",
        "origin": null,
        "year_formed": null,
        "spotify_id": "05fG473iIaoy82BF1aGhL8",
        "image_url": "https://i.scdn.co/image/ab6761610000e5ebd0cdb283a7384a0edb665182",
        "genres": "nu metal, metal, alternative metal, rap metal, heavy metal",
        "followers": 13109589,
        "popularity": 81,
        "spotify_url": "https://open.spotify.com/artist/05fG473iIaoy82BF1aGhL8"
    },
    {
        "id": 6,
        "name": "Nirvana",
        "origin": null,
        "year_formed": null,
        "spotify_id": "6olE6TJLqED3rqDCT0FyPh",
        "image_url": "https://i.scdn.co/image/84282c28d851a700132356381fcfbadc67ff498b",
        "genres": "grunge, rock",
        "followers": 22006372,
        "popularity": 84,
        "spotify_url": "https://open.spotify.com/artist/6olE6TJLqED3rqDCT0FyPh"
    }
]
```