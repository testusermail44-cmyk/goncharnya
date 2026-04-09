<?php

function addView($pdo, $id, $views)
{
    $stmt = $pdo->prepare("UPDATE products SET views = ? WHERE id = ?");
    $stmt->execute([$views + 1, $id]);
}

function getProductsForCart($pdo, $products)
{
    $placeholders = str_repeat('?,', count($products) - 1) . '?';
    $stmt = $pdo->prepare("SELECT p.amount, p.image, p.price, p.volume, p.name, p.id, c.name as color, ct.name as category 
    FROM products as p, colors as c, categories as ct 
    WHERE p.color = c.id AND p.category = ct.id AND p.id IN ($placeholders)");
    $stmt->execute($products);
    return $stmt->fetchAll();
}
function getAllProductsCount($pdo)
{
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM products");
    $stmt->execute();
    return $stmt->fetch();
}

function createLimit($start, $limit)
{
    if ($start == 1)
        $start = 0;
    else
        $start = ($start - 1) * $limit;
    $sql = '';
    if ($limit)
        $sql = ' LIMIT ' . $start . ', ' . $limit;
    return $sql;
}

function getProducts($pdo, $start, $limit = null): mixed
{
    $sql = '';
    if ($limit != null)
        $sql = createLimit($start, $limit);
    $stmt = $pdo->prepare("SELECT p.id, c.name as category, p.name as product, p.price, p.image FROM products as p, categories as c WHERE p.category = c.id" . $sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getProduct($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT c.name as category, c.id as ctid, p.name, p.description, p.price, 
                        s.name as style, s.id as sid, cl.id as cid, cl.name as color_name, cl.color as color, p.weight, p.temperature, p.diameter, p.height, 
                        p.volume, p.image, p.views, p.amount
                        FROM products as p, categories as c, styles as s, colors as cl 
                        WHERE p.category = c.id AND p.color = cl.id AND p.style = s.id AND p.id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getMaxPrice($pdo): int
{
    $stmt = $pdo->prepare("SELECT MAX(price) as max FROM products");
    $stmt->execute();
    return $stmt->fetch()->max;
}

function getStyles($pdo)
{
    $stmt = $pdo->prepare("SELECT id, name FROM styles");
    $stmt->execute();
    return $stmt->fetchAll();
}

function getColors($pdo)
{
    $stmt = $pdo->prepare("SELECT id, name FROM colors");
    $stmt->execute();
    return $stmt->fetchAll();
}

function getCategories($pdo)
{
    $stmt = $pdo->prepare("SELECT id, name FROM categories");
    $stmt->execute();
    return $stmt->fetchAll();
}

function searchProduct($pdo, $search, $start, $limit = null)
{
    $sql = createLimit($start, $limit);
    $stmt = $pdo->prepare("SELECT p.id, c.name as category, p.name as product, p.price, p.image FROM products as p, categories as c WHERE p.category = c.id AND p.name LIKE ? AND p.description LIKE ?" . $sql);
    $search = "%$search%";
    $stmt->execute([$search, $search]);
    return $stmt->fetchAll();
}

function getSearchCount($pdo, $search)
{
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM products p, categories c WHERE p.category = c.id AND p.name LIKE ? AND p.description LIKE ?");
    $search = "%$search%";
    $stmt->execute([$search, $search]);
    return $stmt->fetch();
}

function filter($pdo, $price, $category, $color, $style, $start, $limit)
{
    $sql = createLimit($start, $limit);
    $conditions = [];
    $params = [];
    if (!empty($price)) {
        $conditions[] = 'p.price <= ?';
        $params[] = (int) $price;
    }
    if (!empty($style)) {
        $style = (array) $style;
        $placeholders = implode(',', array_fill(0, count($style), '?'));
        $conditions[] = "p.style IN ($placeholders)";
        $params = array_merge($params, array_map('intval', $style));
    }
    if (!empty($color)) {
        $color = (array) $color;
        $placeholders = implode(',', array_fill(0, count($color), '?'));
        $conditions[] = "p.color IN ($placeholders)";
        $params = array_merge($params, array_map('intval', $color));
    }
    if (!empty($category)) {
        $category = (array) $category;
        $placeholders = implode(',', array_fill(0, count($category), '?'));
        $conditions[] = "p.category IN ($placeholders)";
        $params = array_merge($params, array_map('intval', $category));
    }
    $where = 'WHERE p.category = c.id';
    if (!empty($conditions)) {
        $where .= ' AND ' . implode(' AND ', $conditions);
    }
    $where .= $sql;
    $stmt = $pdo->prepare("
        SELECT p.id, c.name as category, p.name as product, p.price, p.image
        FROM products as p, categories as c
        $where
    ");
    $countStmt = $pdo->prepare("
        SELECT COUNT(*) as count
        FROM products as p, categories as c
        $where
    ");
    $countStmt->execute($params);
    $count = $countStmt->fetch();
    $stmt->execute($params);
    return [
        'products' => $stmt->fetchAll(),
        'count' => $count,
    ];
}

function removeFromStorage($pdo, $products, $amounts)
{
    $stmt = $pdo->prepare("UPDATE products SET amount = ? WHERE id = ?");
    foreach ($products as $item) {
        $id = $item['product'];
        $countBought = $item['count'];
        if (isset($amounts[$id][0])) {
            $currentStock = $amounts[$id][0];
            $newAmount = $currentStock - $countBought;
            $stmt->execute([$newAmount, $id]);
        }
    }
}

function updateCategory($pdo, $id, $name){
    $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
    $stmt->execute([$name, $id]);
}

function newCategory($pdo, $name){
    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->execute([$name]);
}

function delCategory($pdo, $id){
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
}

function createProduct($pdo, $name, $category, $color, $style, $price, $description, $weight, $temperature, $diameter, $height, $volume, $amount, $image) {
    $sql = "INSERT INTO products (name, category, color, style, price, description, weight, temperature, diameter, height, volume, image, amount) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $name, $category, $color, $style, $price, $description, 
        $weight ?: 0, $temperature ?: 0, $diameter ?: 0, $height ?: 0, $volume ?: 0, 
        $image ?: 'default.png', $amount ?: 0
    ]);
}

function updateProduct($pdo, $id, $name, $category, $color, $style, $price, $description, $weight, $temperature, $diameter, $height, $volume, $amount, $image) {
    $sql = "UPDATE products SET name=?, category=?, color=?, style=?, price=?, description=?, weight=?, temperature=?, diameter=?, height=?, volume=?, image=?, amount=? 
            WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $name, $category, $color, $style, $price, $description, 
        $weight ?: 0, $temperature ?: 0, $diameter ?: 0, $height ?: 0, $volume ?: 0, 
        $image ?: 'default.png', $amount ?: 0, $id
    ]);
}

function deleteProduct($pdo, $id){
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
}
?>