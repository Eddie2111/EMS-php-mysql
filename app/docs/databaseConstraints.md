## Database Details
provider = "mysql"
url      = env("DATABASE_URL")

## Tables and relations
```prisma
table User {
  id        Int      @id @default(autoincrement())
  email     String   @unique
  password  String
  name      String?
  phone     String?
  createdAt DateTime @default(now())
  updatedAt DateTime @updatedAt

  events   Event[]
  Attendee Attendee[]
}
```

```prisma
table Event {
  id          Int      @id @default(autoincrement())
  title       String
  description String?
  startDate   DateTime
  endDate     DateTime
  location    String?
  capacity    Int?
  createdAt   DateTime @default(now())
  updatedAt   DateTime @updatedAt

  creator   User @relation(fields: [creatorId], references: [id])
  creatorId Int

  attendees Attendee[]
}
```

```prisma
table Attendee {
  id      Int @id @default(autoincrement())
  eventId Int
  userId  Int

  event Event @relation(fields: [eventId], references: [id])
  user  User  @relation(fields: [userId], references: [id])

  @@unique([eventId, userId])
}
```