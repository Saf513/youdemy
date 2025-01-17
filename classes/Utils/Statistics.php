<?php

class Statistics {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }
    public function getTeacherStatistics(int $teacherId): array {
        try {
            // Get total courses
            $coursesQuery = "SELECT COUNT(*) as total_courses FROM courses WHERE user_id = :user_id";
            $coursesResult = $this->db->executeQuery($coursesQuery, ['user_id' => $teacherId]);
            $totalCourses = $coursesResult[0]['total_courses'] ?? 0;
        
            // Get total students enrolled
            $studentsQuery = "SELECT COUNT(DISTINCT e.student_id) as total_students 
                             FROM enrollments e 
                             JOIN courses c ON e.course_id = c.id 
                             WHERE c.user_id = :user_id";
            $studentsResult = $this->db->executeQuery($studentsQuery, ['user_id' => $teacherId]);
            $totalStudents = $studentsResult[0]['total_students'] ?? 0;
        
            // Get courses with enrollment counts
            $coursesDetailsQuery = "SELECT 
                c.id, 
                c.title, 
                c.status, 
                c.created_at,
                COUNT(e.student_id) as enrollment_count
            FROM courses c 
            LEFT JOIN enrollments e ON c.id = e.course_id 
            WHERE c.user_id = :user_id 
            GROUP BY c.id, c.title, c.status, c.created_at
            ORDER BY c.created_at DESC";
            
            $coursesDetails = $this->db->executeQuery($coursesDetailsQuery, ['user_id' => $teacherId]);
            
            // Ensure coursesDetails is always an array
            $coursesDetails = $coursesDetails !== false ? $coursesDetails : [];
        
            $avgEnrollments = $totalCourses > 0 ? ($totalStudents / $totalCourses) : 0;
        
            return [
                'total_courses' => $totalCourses,
                'total_students' => $totalStudents,
                'average_enrollments' => round($avgEnrollments, 2),
                'courses_details' => $coursesDetails  // Will now always be an array
            ];
        } catch (Exception $e) {
            // Log the error if you have a logging system
            // For now, return empty statistics
            return [
                'total_courses' => 0,
                'total_students' => 0,
                'average_enrollments' => 0,
                'courses_details' => []
            ];
        }
    }
    public function getCourseStatistics(int $courseId): array {
        // Get total enrollments for the course
        $enrollmentsQuery = "SELECT COUNT(*) as total_enrollments FROM enrollments WHERE course_id = :course_id";
        $enrollmentsResult = $this->db->executeQuery($enrollmentsQuery, ['course_id' => $courseId]);
        
        // Get recent enrollments (last 30 days)
        $recentEnrollmentsQuery = "SELECT COUNT(*) as recent_enrollments 
                                  FROM enrollments 
                                  WHERE course_id = :course_id 
                                  AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
        $recentEnrollmentsResult = $this->db->executeQuery($recentEnrollmentsQuery, ['course_id' => $courseId]);

        return [
            'total_enrollments' => $enrollmentsResult[0]['total_enrollments'] ?? 0,
            'recent_enrollments' => $recentEnrollmentsResult[0]['recent_enrollments'] ?? 0
        ];
    }

    public static function getGlobalStatistics(): array
    {
        $db = new Database('localhost', 'youdemy', 'root', 'root');
        
           $totalCoursesQuery = "SELECT COUNT(*) AS totalCourses FROM courses";
        $totalCoursesResult = $db->executeQuery($totalCoursesQuery);
        $totalCourses = is_array($totalCoursesResult) && isset($totalCoursesResult[0]['totalCourses'])  ? (int)$totalCoursesResult[0]['totalCourses'] : 0;


        $coursesPerCategoryQuery = " SELECT c.name, COUNT(co.id) AS courseCount   FROM categories c   LEFT JOIN courses co ON c.id = co.category_id     GROUP BY c.name    ";

       $coursesPerCategory =  $db->executeQuery($coursesPerCategoryQuery)?? [];


             // Most enroled course
          $mostEnrolledCourseQuery  = " SELECT c.title, COUNT(es.student_id) as students_count     FROM courses c   INNER JOIN enrollments es ON c.id = es.course_id   GROUP BY c.id    ORDER BY students_count DESC   LIMIT 1    ";


            $mostEnrolledCourse= $db->executeQuery($mostEnrolledCourseQuery) ?? null;
                 // Top 3 teachers
            $topTeachersQuery ="
           SELECT u.full_name AS nom, COUNT(co.id) AS courseCount     FROM users u    LEFT JOIN courses co ON u.id = co.teacher_id      WHERE u.role = 'teacher'   GROUP BY u.id   ORDER BY courseCount DESC      LIMIT 3 ";
          $topTeachers = $db->executeQuery($topTeachersQuery) ?? [];


      return [
            'totalCourses' => $totalCourses,
                'coursesPerCategory' => $coursesPerCategory,
               'mostEnrolledCourse' => is_array($mostEnrolledCourse) ?   $mostEnrolledCourse[0]: [],
               'topTeachers' => $topTeachers,
       ];



   }

}