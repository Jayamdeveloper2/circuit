USE circuitbrilliance_db;
UPDATE web_content SET 
  web_content_1 = 'For Students & Graduates',
  web_content_2 = 'The Recruiter Moment',
  web_content_3 = 'A technical recruiter sits across 40 final-year students. Interview after interview — textbook answers, nervous faces, same pattern. Then one student walks in.',
  web_content_4 = 'Asked about gate drive design for a SiC MOSFET, he does not recite a definition. He talks about turn-on resistance, Miller plateau, negative bias requirements, layout parasitics — the way a working engineer speaks after two years on the job.',
  web_content_5 = 'The recruiter stops writing. Looks up. "Where did you learn this?"',
  web_content_6 = 'Certificate Programme in Power Electronics Product Development',
  web_content_7 = 'A 3-month structured programme — 30% concepts, 70% real design work. Students design a real power electronics product from blank schematic to fabrication-ready output, using the same tools that engineers use in real companies.',
  web_content_8 = '[{"num":"40","text":"Students interviewed, same generic result"},{"num":"1","text":"Student who stood apart with real design instinct"},{"badge":"DAY 1","text":"Ready to contribute, what recruiters actually want"}]',
  web_content_9 = '[{"icon":"fa-clock","name":"Duration","text":"3 months"},{"icon":"fa-laptop","name":"Delivery","text":"Online delivery"},{"icon":"fa-calendar-alt","name":"Schedule","text":"Weekend + weekday sessions"},{"icon":"fa-medal","name":"Outcome","text":"Certificate + Digital Badge + Portfolio"}]',
  web_image_1   = 'peri-interview.webp',
  status        = 1
WHERE web_content_id = 19;
