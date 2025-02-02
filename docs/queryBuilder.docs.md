# QueryBuilder

## Description

This ensures safe execution of the SQL queries and also helps in preventing SQL injection attacks.
Plus, it abstracts the SQL syntax, making it easier to write and maintain the code.
Also, it provides a way to build SQL queries programmatically, which can be useful in dynamic SQL queries.

## Technical Philosophy

The QueryBuilder class is designed to be used in a way that is as close to the SQL syntax as possible. This means that the methods used to build the query are named in a way that reflects the SQL syntax.

## Usage

### Connect to Database

```php
$queryBuilder = new QueryBuilder('mysql:host=localhost;dbname=test', 'username', 'password');
```

### Create Data

```php
$data = [

    'name' => 'Tech Conference',

    'description' => 'A conference about technology.',

    'max_capacity' => 100

];


$queryBuilder->insert('events', $data);
```

### Find data

```php
$conditions = ['id' => 1];

$events = $queryBuilder->select('events', '*', $conditions);

print_r($events);
```

### Update data

```php
$data = ['name' => 'Updated Conference'];

$conditions = ['id' => 1];

$queryBuilder->update('events', $data, $conditions);
```


### Delete data

```php
$conditions = ['id' => 1];

$queryBuilder->delete('events', $conditions);
```


### Join data

```php
$joins = [

    [

        'type' => 'INNER',        // Join type (INNER, LEFT, RIGHT, etc.)

        'table' => 'attendees',  // Table to join

        'on' => 'events.id = attendees.event_id'  // Join condition

    ]

];

$conditions = ['events.id' => 1];

$results = $queryBuilder->selectWithJoin('events', 'events.name, attendees.name as attendee_name', $joins, $conditions);

print_r($results);
```


### Transaction

```php
try {

    $queryBuilder->beginTransaction();


    // Insert an event

    $eventData = [

        'name' => 'Tech Conference',

        'description' => 'A conference about tech.',

        'max_capacity' => 200

    ];

    $queryBuilder->insert('events', $eventData);


    // Get the last inserted event ID

    $eventId = $pdo->lastInsertId();


    // Insert attendees

    $attendeeData1 = ['event_id' => $eventId, 'name' => 'John Doe'];

    $attendeeData2 = ['event_id' => $eventId, 'name' => 'Jane Smith'];


    $queryBuilder->insert('attendees', $attendeeData1);

    $queryBuilder->insert('attendees', $attendeeData2);


    // Commit the transaction

    $queryBuilder->commit();

    echo "Event and attendees added successfully!";

} catch (Exception $e) {

    // Rollback the transaction on error

    $queryBuilder->rollBack();

    echo "Failed to add event and attendees: " . $e->getMessage();

}
```