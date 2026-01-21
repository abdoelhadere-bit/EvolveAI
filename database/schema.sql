-- Active: 1768302342360@@127.0.0.1@5432@evolveai
DROP DATABASE IF EXISTS evolveai;

CREATE DATABASE evolveai;

CREATE ROLE evolveai_user WITH LOGIN PASSWORD 'evolveai';
GRANT ALL PRIVILEGES ON DATABASE evolveai TO evolveai_user;

\c evolveai;

CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE user_profiles (
  id SERIAL PRIMARY KEY,
  user_id INT NOT NULL UNIQUE REFERENCES users(id) ON DELETE CASCADE,
  ai_familiarity VARCHAR(50) NOT NULL,
  income_goal NUMERIC(10,2) NOT NULL DEFAULT 0,
  time_per_day INT NOT NULL DEFAULT 30,
  learning_preference VARCHAR(50) NOT NULL,
  professional_status VARCHAR(50) NOT NULL,
  past_experience TEXT,
  updated_at TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE daily_plans (
  id SERIAL PRIMARY KEY,
  user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  plan_date DATE NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'active',
  progress_percent INT NOT NULL DEFAULT 0,
  UNIQUE (user_id, plan_date)
);

CREATE TABLE plan_tasks (
  id SERIAL PRIMARY KEY,
  plan_id INT NOT NULL REFERENCES daily_plans(id) ON DELETE CASCADE,
  title VARCHAR(150) NOT NULL,
  description TEXT,
  status VARCHAR(20) NOT NULL DEFAULT 'todo',
  deadline TIMESTAMP NULL
);

CREATE TABLE task_submissions (
  id SERIAL PRIMARY KEY,
  task_id INT NOT NULL UNIQUE REFERENCES plan_tasks(id) ON DELETE CASCADE,
  content TEXT NOT NULL,
  submitted_at TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE ai_reviews (
  id SERIAL PRIMARY KEY,
  submission_id INT NOT NULL UNIQUE REFERENCES task_submissions(id) ON DELETE CASCADE,
  score INT NOT NULL DEFAULT 0,
  feedback TEXT,
  reviewed_at TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE opportunities (
  id SERIAL PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  description TEXT NOT NULL,
  estimated_earnings VARCHAR(100),
  created_at TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE user_opportunities (
  id SERIAL PRIMARY KEY,
  user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  opportunity_id INT NOT NULL REFERENCES opportunities(id) ON DELETE CASCADE,
  status VARCHAR(30) NOT NULL DEFAULT 'selected',
  selected_at TIMESTAMP NOT NULL DEFAULT NOW(),
  UNIQUE (user_id, opportunity_id)
);

