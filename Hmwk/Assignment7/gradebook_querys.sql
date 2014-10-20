SELECT `bw1780661_entity_class`.`section_id`,
       `bw1780661_enum_discipline`.`menumonic`,
       `bw1780661_entity_course`.`number`,
       `bw1780661_entity_course`.`series_letter`,
       `bw1780661_entity_course`.`name`,
       `bw1780661_entity_course`.`short_description`,
       `bw1780661_enum_bldg_class`.`building`,
       `bw1780661_entity_class`.`room`,
       `bw1780661_entity_instructor`.`last_name`,
       `bw1780661_entity_instructor`.`first_name` AS `Instructor First Name`,
       `bw1780661_enum_semester`.`semester`,
       `bw1780661_enum_daysofweek`.`days_of_week`,
       `bw1780661_entity_class`.`time`,
       `bw1780661_entity_class`.`start_date`,
       `bw1780661_entity_class`.`end_date`
FROM `48075`.`bw1780661_enum_daysofweek` AS `bw1780661_enum_daysofweek`,
     `48075`.`bw1780661_entity_class` AS `bw1780661_entity_class`,
     `48075`.`bw1780661_enum_bldg_class` AS `bw1780661_enum_bldg_class`,
     `48075`.`bw1780661_enum_semester` AS `bw1780661_enum_semester`,
     `48075`.`bw1780661_xref_class_course` AS `bw1780661_xref_class_course`,
     `48075`.`bw1780661_entity_course` AS `bw1780661_entity_course`,
     `48075`.`bw1780661_enum_discipline` AS `bw1780661_enum_discipline`,
     `48075`.`bw1780661_xref_instr_class` AS `bw1780661_xref_instr_class`,
     `48075`.`bw1780661_entity_instructor` AS `bw1780661_entity_instructor`
WHERE `bw1780661_enum_daysofweek`.`day_id` = `bw1780661_entity_class`.`day_of_Week`
  AND `bw1780661_enum_bldg_class`.`bldg_id` = `bw1780661_entity_class`.`bldg`
  AND `bw1780661_enum_semester`.`sem_id` = `bw1780661_entity_class`.`semester`
  AND `bw1780661_xref_class_course`.`course_id` = `bw1780661_entity_course`.`course_id`
  AND `bw1780661_entity_class`.`section_id` = `bw1780661_xref_class_course`.`class_id`
  AND `bw1780661_entity_course`.`discipline_id` = `bw1780661_enum_discipline`.`disc_id`
  AND `bw1780661_xref_instr_class`.`class_id` = `bw1780661_entity_class`.`section_id`
  AND `bw1780661_entity_instructor`.`instructor_id` = `bw1780661_xref_instr_class`.`instructor_id`
  
  SELECT `bw1780661_enum_discipline`.`menumonic`,
         `bw1780661_entity_course`.`number`,
         `bw1780661_entity_course`.`series_letter`,
         `bw1780661_entity_course`.`name`,
         `bw1780661_entity_course`.`short_description`
  FROM `48075`.`bw1780661_enum_discipline` AS `bw1780661_enum_discipline`,
       `48075`.`bw1780661_entity_course` AS `bw1780661_entity_course` WHERE `bw1780661_enum_discipline`.`disc_id` = `bw1780661_entity_course`.`discipline_id`

  SELECT `bw1780661_entity_instructor`.`instructor_id` AS `Instructor ID#`,
         `bw1780661_entity_instructor`.`first_name` AS `First Name`,
         `bw1780661_entity_instructor`.`middle_initial` AS `Middle Initial`,
         `bw1780661_entity_instructor`.`last_name` AS `Last Name`,
         `bw1780661_entity_instructor`.`email_address` AS `email address`,
         `bw1780661_entity_instructor`.`area_code` AS `Area Code`,
         `bw1780661_entity_instructor`.`phone_number` AS `Phone Number`,
         `bw1780661_enum_bldg_instr`.`building` AS `Office Building`,
         `bw1780661_enum_bldg_instr`.`mneumonic` AS `Office Building (Short)`,
         `bw1780661_entity_instructor`.`office_number` AS `Office Room Number`,
         `bw1780661_enum_department`.`department` AS `Department`,
         `bw1780661_enum_discipline`.`discipline` AS `Discipline`,
         `bw1780661_enum_discipline`.`menumonic` AS `Discipline (Short)`
  FROM `48075`.`bw1780661_enum_bldg_instr` AS `bw1780661_enum_bldg_instr`,
       `48075`.`bw1780661_entity_instructor` AS `bw1780661_entity_instructor`,
       `48075`.`bw1780661_enum_department` AS `bw1780661_enum_department`,
       `48075`.`bw1780661_enum_discipline` AS `bw1780661_enum_discipline` WHERE `bw1780661_enum_bldg_instr`.`bldg_id` = `bw1780661_entity_instructor`.`office_bldg_id`
  AND `bw1780661_enum_department`.`dept_id` = `bw1780661_entity_instructor`.`department_id`
  AND `bw1780661_enum_discipline`.`disc_id` = `bw1780661_entity_instructor`.`discipline_id`
  
  SELECT `bw1780661_entity_student`.`student_id` AS `Student ID#`,
         `bw1780661_entity_student`.`first_name` AS `First Name`,
         `bw1780661_entity_student`.`middle_initial` AS `Middle Initial`,
         `bw1780661_entity_student`.`last_name` AS `Last Name`,
         `bw1780661_entity_student`.`email_address` AS `email address`,
         `bw1780661_entity_student`.`area_code` AS `Area Code`,
         `bw1780661_entity_student`.`phone_number` AS `Phobe Number`,
         `bw1780661_enum_discipline`.`discipline` AS `Major`,
         `bw1780661_enum_discipline`.`menumonic` AS `Major(Short)`
  FROM `48075`.`bw1780661_entity_student` AS `bw1780661_entity_student`,
       `48075`.`bw1780661_enum_discipline` AS `bw1780661_enum_discipline` WHERE `bw1780661_entity_student`.`discipline_id` = `bw1780661_enum_discipline`.`disc_id`