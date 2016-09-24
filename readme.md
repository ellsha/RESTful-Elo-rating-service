## Route list
```
+----------+------------------------------+-----------------+------------------------------------------------+------------+
| Method   | URI                          | Name            | Action                                         | Middleware |
+----------+------------------------------+-----------------+------------------------------------------------+------------+
| GET|HEAD | api/matches                  | matches.index   | App\Http\Controllers\MatchesController@index   | api        |
| POST     | api/matches                  | matches.store   | App\Http\Controllers\MatchesController@store   | api        |
| DELETE   | api/matches/{match}          | matches.destroy | App\Http\Controllers\MatchesController@destroy | api        |
| PATCH    | api/matches/{match}          | matches.update  | App\Http\Controllers\MatchesController@update  | api        |
| GET|HEAD | api/matches/{match}          | matches.show    | App\Http\Controllers\MatchesController@show    | api        |
| GET|HEAD | api/players/{player}         | players.rating  | App\Http\Controllers\PlayersController@rating  | api        |
| GET|HEAD | api/players/{player}/matches | players.matches | App\Http\Controllers\PlayersController@matches | api        |
+----------+------------------------------+-----------------+------------------------------------------------+------------+
```

### Get a list of matches

```shell
$ curl -v GET 'http://127.0.0.1/api/matches'
```
```php
< HTTP/1.1 200 OK
```
```json
[
  {
    "id": 4,
    "started_at": "2000-04-23 18:25:43",
    "finished_at": "2000-04-30 20:00:00",
    "winner_id": "3",
    "log": "some log",
    "players": [
      {
        "id": 1,
        "elo_rating": "1192",
        "pivot": {
          "match_id": "4",
          "player_id": "1"
        }
      },
      {
        "id": 3,
        "elo_rating": "2060",
        "pivot": {
          "match_id": "4",
          "player_id": "3"
        }
      }
    ]
  },
  ...
 ]
```

### Save the match result

```shell
$ curl -v POST -H "Content-type: application/json" -d '{
	"started_at":"2010-04-23 18:25:43",
	"finished_at":"2011-04-24 20:21:32",
	"players_id":[2,3],
	"winner_id":2,
	"log":"some log"
}' 'http://127.0.0.1/api/matches'
```

```php
< HTTP/1.1 201 Created
```
```json
{
  "id": 61,
  "started_at": "2010-04-23 18:25:43",
  "finished_at": "2011-04-24 20:21:32",
  "winner_id": "2",
  "log": "some log",
  "players": [
    {
      "id": 2,
      "elo_rating": "1465",
      "pivot": {
        "match_id": "61",
        "player_id": "2"
      }
    },
    {
      "id": 3,
      "elo_rating": "1982",
      "pivot": {
        "match_id": "61",
        "player_id": "3"
      }
    }
  ]
}
```

### Delete information about the match

```shell
$ curl -v DELETE 'http://127.0.0.1/api/matches/61'
```

```php
< HTTP/1.1 204 No Content
```

### Edit match data

```shell
$ curl -v PATCH -H "Content-type: application/json" -d '{
	"started_at":"1990-04-23 10:00:22"
}' 'http://127.0.0.1/api/matches/40'
```

```php
< HTTP/1.1 200 OK
```
```json
{
  "id": 40,
  "started_at": "1990-04-23 10:00:22",
  "finished_at": "2000-04-30 20:00:00",
  "winner_id": "3",
  "log": "some log",
  "players": [
    {
      "id": 1,
      "elo_rating": "1192",
      "pivot": {
        "match_id": "4",
        "player_id": "1"
      }
    },
    {
      "id": 3,
      "elo_rating": "1944",
      "pivot": {
        "match_id": "4",
        "player_id": "3"
      }
    }
  ]
}
```

### Get information about the match

```shell
curl -v GET 'http://127.0.0.1/api/matches/40'
```

```php
< HTTP/1.1 200 OK
```
```json
{
  "id": 40,
  "started_at": "1990-04-23 10:00:22",
  "finished_at": "2091-04-23 18:25:43",
  "winner_id": "2",
  "log": null,
  "players": [
    {
      "id": 1,
      "elo_rating": "1192",
      "pivot": {
        "match_id": "40",
        "player_id": "1"
      }
    },
    {
      "id": 2,
      "elo_rating": "1484",
      "pivot": {
        "match_id": "40",
        "player_id": "2"
      }
    }
  ]
}
```

### Get player's rating

```shell
$ curl -v GET 'http://127.0.0.1/api/players/1'
```
```php
< HTTP/1.1 200 OK
```
```php
"1192"
```

### Get a list of matches played by the player

```shell
curl -v -GET 'http://127.0.0.1/api/players/1/matches'
```

```php
< HTTP/1.1 200 OK
```
```json
[
  {
    "id": 2,
    "started_at": "2015-04-23 18:25:43",
    "finished_at": "2014-04-30 20:00:00",
    "winner_id": "1",
    "log": "some log",
    "pivot": {
      "player_id": "1",
      "match_id": "2"
    },
    "players": [
      {
        "id": 1,
        "elo_rating": "1192",
        "pivot": {
          "match_id": "2",
          "player_id": "1"
        }
      },
      {
        "id": 2,
        "elo_rating": "1484",
        "pivot": {
          "match_id": "2",
          "player_id": "2"
        }
      }
    ]
  },
  ...
]
```