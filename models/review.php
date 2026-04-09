<?php
    function getReviews($pdo, $id) {
        $stmt = $pdo->prepare("SELECT r.id, r.text, r.date, r.rating, u.name, u.surname, u.image, u.id as user FROM reviews as r, users as u WHERE r.user = u.id AND r.product = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    function addReview($pdo, $user, $product, $text, $rating){
        $stmt = $pdo->prepare("INSERT INTO reviews(user, product, text, rating) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user, $product, $text, $rating]);
    }

    function deleteReview($pdo, $id){
        $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->execute([$id]);
    }
?>