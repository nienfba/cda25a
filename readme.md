# Commande de photos

## Présentation des tables et entités

1. **customers** : Stocke les informations sur les customers qui ont passé des commandes. Chaque client est identifié par un `client_id` unique.

2. **photos** : Contient les détails des photos disponibles à la vente. Chaque photo est identifiée par un `photo_id` unique.

3. **orders** : Enregistre les commandes passées par les customers. Chaque commande est identifiée par un `order_id` unique. La table a une relation "many-to-one" avec la table `customers`, où plusieurs commandes peuvent être associées à un seul client.

4. **order_items** : Stocke les détails des articles individuels dans chaque commande. Chaque article est identifié par un `order_item_id` unique. La table a des relations "many-to-one" avec les tables `orders` et `photos`, où plusieurs articles peuvent être associés à une seule commande et à une seule photo.

5. **tags** : Contient les étiquettes associées aux photos. Chaque étiquette est identifiée par un `tag_id` unique.

6. **photo_tags** : Établit une relation de plusieurs à plusieurs entre les photos et les étiquettes. Cette table de liaison associe les photos aux étiquettes correspondantes.

En résumé, les relations principales sont les suivantes :
- `customers` -> `orders` : Relation "one-to-many". Un client peut passer plusieurs commandes.
- `orders` -> `order_items` : Relation "one-to-many". Une commande peut contenir plusieurs articles.
- `photos` -> `order_items` : Relation "one-to-many". Une photo peut être incluse dans plusieurs articles de commande.
- `photos` -> `photo_tags` -> `tags` : Relation "many-to-many". Une photo peut avoir plusieurs étiquettes, et une étiquette peut être associée à plusieurs photos.


## Diagramme d'entités
```mermaid
erDiagram
    customer {
        int id PK
        string(255) name
        string(255) email
        int age
        string(255) city
    }
    photo {
        int id PK
        string(255) title
        string description
        string(255) image_url
        float price
        json meta_info
    }

    order {
        int id PK
        int customer_id FK
        date created_at
    }

    order_item {
        int id PK
        int order_id FK
        int photo_id FK
        int quantity FK
        float price
    }

    tag {
        int id PK
        string(255) name
    }

    photo_tag {
        int tag_id PK, FK
        int photo_id PK, FK
    }

    customer ||--o{ order : has
    order ||--o{ order_item : contains
    photo ||--o{ order_item : contains
    photo ||--o{ photo_tag : has
    tag ||--o{ photo_tag : contains
```

