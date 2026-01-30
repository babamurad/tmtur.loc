-- 1. Сначала проверьте данные (SELECT)
SELECT b.id as booking_id, b.created_at, c.email, c.full_name, b.status
FROM bookings b
JOIN customers c ON b.customer_id = c.id
WHERE c.email LIKE '%mailinator%';

-- 2. ПОЛНОЕ УДАЛЕНИЕ (Hard Delete) бронирований
-- Удалит записи из таблицы bookings навсегда
DELETE FROM bookings 
WHERE customer_id IN (
    SELECT id FROM customers WHERE email LIKE '%mailinator%'
);

-- 3. Опционально: Удалить самих тестовых клиентов
-- DELETE FROM customers WHERE email LIKE '%mailinator%';
