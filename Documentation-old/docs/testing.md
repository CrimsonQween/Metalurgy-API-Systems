# Testing Summary

This section outlines the API testing process using Postman.

## Tools Used
- Postman for sending requests
- MySQL (phpMyAdmin) to verify data

## Process
1. Authenticated with external APIs (Spotify, LastFM)
2. Sent requests to endpoints:
   - Created test users, bands, and songs
   - Verified genre and song linkage
   - Tested error cases (missing parameters, invalid IDs)

## Example Postman Request
**POST /users**
Body:
```json
{
  "username": "testuser",
  "email": "test@example.com",
  "password": "password123"
}
```
Response:
```json
{
  "message": "User created successfully"
}
```
