# External API Integrations

## Spotify

| Method | Endpoint                   | Description               |
|--------|----------------------------|---------------------------|
| GET    | Band Lookup                | Lookup band on Spotify    |
| GET    | Album Lookup               | Lookup album on Spotify   |
| GET    | Songs Lookup               | Lookup songs on Spotify   |

## Last.fm & MusicBrainz

| Method | Endpoint                    | Description                     |
|--------|-----------------------------|---------------------------------|
| GET    | Genre Lookup External       | External genre lookup           |
| GET    | Sub Genre Lookup External   | External subgenre lookup                                 |             

### Example

**GET spotify/band_lookup.php?q=megadeth&=&=**
```json
{
  "Band added succesfully"
}
```

**GET spotify/album_lookup.php?band_spotify_id=fdfhgghjhjm**
```json
{
  "Albums added successfully"
}
```

**GET spotify/album_lookup.php?album_spotify_id=1Yox196W7bzVNZI7RBaPnf**
```json
{
  "Albums added successfully"
}
```

**GET genres/genrelookup.php?query=metal**
```json
{
  "Genres added successfully"
}
```
