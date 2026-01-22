-- Active: 1768316508774@@127.0.0.1@5432@evolveai
CREATE TABLE IF NOT EXISTS user_profiles (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL UNIQUE,
    age VARCHAR(50),
    main_goal VARCHAR(100),
    income VARCHAR(100),
    ai_exp VARCHAR(100),
    industry VARCHAR(100),
    automation VARCHAR(100),
    bottleneck VARCHAR(100),
    team VARCHAR(100),
    budget VARCHAR(100),
    chatbots VARCHAR(100),
    content VARCHAR(100),
    sales VARCHAR(100),
    coding VARCHAR(100),
    growth VARCHAR(100),
    device VARCHAR(100),
    learning VARCHAR(100),
    platform VARCHAR(100),
    networking VARCHAR(100),
    vision VARCHAR(100),
    daily_time VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);

SELECT* from user_profiles ;
ALTER TABLE user_profiles
ADD COLUMN answers JSONB;
SELECT answers FROM user_profiles WHERE user_id = 1;

drop table 
