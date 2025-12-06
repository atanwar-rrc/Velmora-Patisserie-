-- Update products with placeholder cake images from free sources
UPDATE product SET url = 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400' WHERE id = 1 AND name LIKE '%Chocolate%';
UPDATE product SET url = 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400' WHERE id = 2 AND name LIKE '%Wedding%';
UPDATE product SET url = 'https://images.unsplash.com/photo-1614707267537-b85aaf00c4b7?w=400' WHERE id = 3 AND name LIKE '%Cupcake%';
UPDATE product SET url = 'https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?w=400' WHERE id = 4 AND name LIKE '%Tart%';
UPDATE product SET url = 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=400' WHERE id = 5 AND name LIKE '%Chocolate%' AND id = 5;
UPDATE product SET url = 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=400' WHERE id = 6 AND name LIKE '%Strawberry%';
