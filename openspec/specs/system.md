# System Specification: Projeto Gestar

## Overview
Projeto Gestar is a web application designed for health and social management, specifically focused on tracking and managing prenatal care for pregnant women ("Gestantes"). The system supports both patient registration and longitudinal atendimento workflows for consultations, visits, risk monitoring, clinical checklists, care plans, and outcome tracking.

## Tech Stack
- **Framework:** Laravel 12
- **Admin Panel:** Filament v3
- **Frontend:** Vue.js
- **Runtime:** PHP 8.2
- **Database:** SQLite
- **Asset Bundling:** Vite
- **Localization:** Portuguese (pt-BR)

## Core Entities
- **Gestante:** Represents a pregnant woman. Contains identification, sociodemographic data, stable health history, obstetric history, habits, and current pregnancy context.
- **Atendimento:** Represents a dated care interaction linked to a Gestante. Contains risk stratification, vaccines, exams, physical exam measurements, birth/newborn data, gestor annotations, and care plan data.
- **User:** System administrators, gestores, and health professionals who create or manage records.

## Architecture
Standard Laravel MVC architecture with Filament providing the administrative interface, CRUD functionality, atendimento workflows, and clinical dashboard components for the core entities.
