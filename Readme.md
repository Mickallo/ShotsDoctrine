<h2> ShotsDoctrine </h2>

This application is a Symfony-based project that demonstrates the use of Doctrine ORM for managing transactions and locks in a banking system. It includes features for transferring funds between accounts while ensuring data consistency and handling concurrency issues.

<h3> Key Features </h3>

 - Account Management: Create, read, and manage bank accounts with balances.
 - Fund Transfer: Transfer funds between accounts with various locking mechanisms to ensure data consistency.
 - Locking Strategies:
    - No Lock: Simple transfers without any locking mechanism.
    - Pessimistic Lock with Wait: Ensures exclusive access to accounts during transfers, waiting for locks to be released.
    - Pessimistic Lock with Error: Attempts to lock accounts for exclusive access, throwing an error if locks cannot be obtained immediately.
    - Optimistic Lock: Uses versioning to detect conflicts and ensure data integrity during concurrent transactions.
 - Concurrency Handling: Demonstrates handling concurrent transactions using different locking strategies.
 - Gatling Integration: Performance testing with Gatling to simulate concurrent requests and analyze system behavior under load.

<h3> Technology Stack </h3>

 - Backend: PHP with Symfony framework.
 - Database: PostgreSQL with Doctrine ORM for data management.
 - Containerization: Docker and Docker Compose for environment setup and management.
 - Performance Testing: Gatling for simulating load and testing the performance of the application.

This application serves as a tutorial and practical example of how to manage database transactions and concurrency in a Symfony project using Doctrine ORM.