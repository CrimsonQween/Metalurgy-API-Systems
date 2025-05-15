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

#### Band Lookup
This endpoint is used to get external information about a specific band. This requires the band name to be inserted as query ( q ).

**GET spotify/band_lookup.php?q=megadeth&=&=**
```json
{
  "Band added succesfully"
}
```

#### Album Lookup
This endpoint is used to get external information about albums from a specific band. This requires the band spotify id to be inserted as a query.

**GET spotify/album_lookup.php?band_spotify_id=fdfhgghjhjm**
```json
{
  "Albums added successfully"
}
```

#### Genre Lookup
This endpoint is used to get external information about a genres. This requires the genre name to be inserted as a query.

**GET genres/genrelookup.php?query=metal**
```json
{
  "Genres added successfully"
}
```
