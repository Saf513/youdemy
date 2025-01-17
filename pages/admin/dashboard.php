<?php
require_once dirname(__DIR__, 2) . '/classes/Auth/Authentification.php';
require_once dirname(__DIR__, 2) . '/classes/User/Admin.php';
require_once dirname(__DIR__, 2) . '/classes/Utils/Statistics.php';
require_once dirname(__DIR__, 2) . '/classes/Auth/Session.php';


Session::start();

$user = Authentification::getUser();

if (!$user || $user->getRole() !== 'admin') {
    header('Location: /pages/auth/login.php');
    exit();
}
$globalStats = Statistics::getGlobalStatistics();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin | Youdemy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="/public/assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .luxe-bg {
            background: linear-gradient(to right, #3730a3, #7e22ce);
        }

        .luxe-card {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05), 0 6px 6px rgba(0, 0, 0, 0.04);
        }

        .side_links svg {
            transition: .5s transform scale(.7)
        }

        .side_links:hover svg {
            transform: scale(1)
        }

        .side_links {
            padding: .75rem;
            transition-property: all;
            transition-duration: .5s;
            display: flex;
            align-items: center;
            color: #ddd;
        }

        .side_links :hover {
            background-color: #191457
        }
    </style>
</head>

<body class="font-montserrat bg-gray-100">

    <?php include_once dirname(__DIR__, 1) . '/common/header.php' ?>


    <!-- Hero/Welcome banner  -->
    <section class="luxe-bg py-24 ">
        <div class="container mx-auto   px-6">
            <h1 class="text-4xl    font-playfair  text-white   font-bold   mb-4   text-center    md:text-left   "> Dashboard admin </h1>
        </div>
    </section>


    <div class="container mx-auto mt-10 px-4 md:px-0">
        <div class="lg:flex">

            <aside class="w-full  lg:w-1/5  bg-white p-6 rounded-lg   luxe-shadow    mb-6 lg:mb-0 mr-6">
                <h3 class="text-lg font-bold mb-4   ">WELCOME <span id="sidebar-user-name"><?= htmlspecialchars($user->getNom()) ?> </span> </h3>
                <ul class="space-y-2  ">
                    <li><a href="/pages/admin/index.php" class="admin-link     flex  items-center  rounded-md      hover:bg-gray-700 transition transform duration-200     p-2"> <i class="fa-solid fa-house "> </i><span> Tableau de bord</span> </a></li>
                    <li> <a href="/pages/admin/manage-users.php" class="admin-link   flex items-center  rounded-md   hover:bg-gray-700    transition transform duration-200     p-2"> <i class="fas  fa-users"> </i> <span> Utilisateurs</span> </a> </li>
                    <li> <a href="/pages/admin/manage-courses.php" class=" admin-link      flex items-center  rounded-md hover:bg-gray-700   transition transform duration-200      p-2"> <i class="fas  fa-book "> </i> <span>Cours </span> </a> </li>
                    <li><a href="#" class="admin-link  flex items-center   rounded-md     hover:bg-gray-700  transition transform duration-200    p-2"> <i class="fas  fa-chart-bar "> </i> <span> Statistiques </span> </a> </li>
                    <li> <a href="#" class=" admin-link  flex  items-center rounded-md  hover:bg-gray-700   transition transform duration-200    p-2"> <i class="fas fa-comments"> </i> <span> Avis </span> </a></li>
                    <li> <a href="#" class="admin-link   flex   items-center rounded-md     hover:bg-gray-700  transition transform duration-200       p-2"> <i class="fas fa-money-bill-wave "> </i> <span> Paiement </span> </a> </li>
                    <hr class="my-4  border-gray-700   ">
                    <li> <a href="/pages/admin/profile.php" class="admin-link   flex    items-center  rounded-md   hover:bg-gray-700 transition transform duration-200     p-2"> <i class="fas    fa-user"></i> <span> Profile </span> </a> </li>
                    <li> <a href="/pages/auth/logout.php" class="  admin-link  text-red-500  flex items-center  rounded-md  hover:bg-gray-700  transition transform duration-200    p-2  "> <i class="fas  fa-sign-out-alt "> </i> <span> Déconnexion </span> </a> </li>
                </ul>
            </aside> <!--  main page  with card like display -->
            <main class=" w-full  lg:w-4/5    p-6     border bg-white     luxe-shadow  ">

                <h2 class="text-2xl  text-purple-700    font-bold mb-4"> Overview </h2>
                <div class="grid    grid-cols-1    md:grid-cols-3    gap-4"> <!-- Card : Total Courses -->
                    <div class=" bg-purple-200        items-center    relative      h-48  rounded-lg flex      px-4       luxe-shadow   "> <svg class="   absolute   top-0   left-0 opacity-40  m-4  fill-[#44076d]" viewBox="0  0   24  24" width="60px">
                            <path d="M17   3.11A6    6 0   0 0   7   3v2.17l-2.01-.48A3  3   0   0 0   3 7.1v13.78A.224.224  0  0  0   3.03  21h17.94a.224.224 0 0 0   .03-.05V7.1A3   3 0    0 0 17 3.11zM5    7.1c.1.13.23.38.58.54L6   8v11H4V7.93l.66.47A2 2  0    0    1    5 7.1zM19  20H5V7h14.18L17  7.9a2  2  0    0   1   .94.33A2.999    2.999    0    0 0   19   7.1z" />
                        </svg>
                        <p class=" text-gray-600     "> Total Coures </p>
                        <h3 id="courses-total" class=" text-5xl    font-bold text-indigo-900 "> <?php echo  htmlspecialchars($globalStats['totalCourses']) ?></h3>
                    </div>


                    <div class="luxe-shadow    bg-blue-200    px-4 py-4    h-48  rounded-lg flex    flex-col   items-start  ">
                        <h3 class="text-lg   font-medium text-blue-600   ">Top 3 Users </h3>
                        <ul class="  w-full    h-32     space-y-1" id="last-registered-user">
                            <?php
                            if ($globalStats['topTeachers']  && count($globalStats['topTeachers']) > 0) {
                                foreach ($globalStats['topTeachers']     as  $user) { ?> <li class="flex     items-center    justify-between  transition transform    duration-300  "> <?= htmlspecialchars($user["nom"]); ?> <span class=" text-purple-500  "> <?= htmlspecialchars($user['courseCount']); ?> </span> </li> <?php   }
                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                        echo   " There is no Teachers registred ";
                                                                                                                                                                                                                                                                                                    }      ?> </ul>
                    </div>


                    <div class="luxe-shadow    flex  flex-col      px-4 py-4      items-start    rounded-lg       h-48 bg-orange-200  ">
                        <h3 class="text-lg text-orange-800  font-medium  "> Most Enroled Course </h3>
                        <p id="most-enrolled" class="text-lg     font-bold     "> <?php if ($globalStats['mostEnrolledCourse']) {
                                                                                        echo  htmlspecialchars(substr($globalStats['mostEnrolledCourse']["title"], 0, 25)) . "... with  "  . htmlspecialchars($globalStats['mostEnrolledCourse']["students_count"]);
                                                                                    } else   echo  ' no Course have been enroled yet  ';    ?> </p>
                    </div>
                    <div class="bg-green-200 luxe-shadow rounded-lg   p-4 h-48   ">
                        <h3 class="  text-green-700  text-lg  font-bold"> Course Per category </h3><canvas id="coursesPerCategory"></canvas>
                    </div>
                </div>

                <!-- user List Table and Charts-->

                <div class=" grid grid-cols-1  lg:grid-cols-2    mt-8  gap-6   ">
                    <div class="luxe-shadow    p-6     bg-white   rounded-md   ">

                        <h2 class="text-xl mb-2  text-purple-700   font-bold"> Users Reccent List </h2>
                        <table class="  leading-normal       min-w-full ">
                            <thead class="bg-gray-200    ">
                                <tr>
                                    <th class="px-6  py-3    border-b-2    text-left   font-semibold     text-gray-600     tracking-wider  uppercase     "> Name </th>
                                    <th class="px-6    py-3     border-b-2     text-left    font-semibold      text-gray-600      tracking-wider   uppercase"> Email </th>
                                    <th class=" px-6  py-3      border-b-2    text-left    font-semibold      text-gray-600   tracking-wider   uppercase"> Subscription </th>
                                    <th class="px-6      py-3   border-b-2       text-left   font-semibold      text-gray-600 tracking-wider uppercase   "> State </th>
                                </tr>
                            </thead>
                            <tbody> <?php if (isset($globalStats['mostEnrolledCourse'])) :     ?>
                                    <tr>
                                        <td class="px-6   py-4   border-b    border-gray-200  text-sm    "> Data goes here </td>
                                        <td class="px-6     py-4   border-b      text-sm border-gray-200"> data@goes.com </td>
                                        <td class="px-6      py-4   border-b      text-sm border-gray-200  ">23 05-2023 </td>
                                        <td class="px-6    py-4     border-b border-gray-200 text-sm"> <span class="   inline-flex px-2 text-xs font-semibold     text-green-800  leading-5  bg-green-200 rounded-full     "> Active </span> </td>
                                    </tr> <?php endif   ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="    luxe-shadow     rounded-lg      bg-white    p-6 ">
                        <h2 class="text-xl font-bold text-purple-600   mb-4"> Users Per Roles Graph </h2>

                        <canvas id="userRoleChart"></canvas>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php include_once  dirname(__DIR__,   1) . '/common/footer.php';   ?>
    <script>
        document.getElementById("sidebar-user-name").textContent = "<?php echo  htmlspecialchars($user->getFullName());  ?>";


        const coursesCategoryData = JSON.parse(`<?php echo json_encode($globalStats['coursesPerCategory'] ?? [],  JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?>`)
        const userRoles = JSON.parse(`<?php echo json_encode($globalStats['topTeachers']   ?? [],  JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);   ?>`);
        const userChart = document.getElementById("userRoleChart");



        new Chart(userChart, {

            type: "bar",
            data: {
                labels: [...userRoles.map(u => u.nom)],
                datasets: [{
                    data: [...userRoles.map(user => user.courseCount)],
                    backgroundColor: ["#50a8f8", '#05a15a', "#b20664", ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Number of courses per each teacher'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }


        })

        const categoryChart = new Chart(document.getElementById('coursesPerCategory'), {
            type: 'doughnut',
            data: {
                labels: [...coursesCategoryData.map(cat => cat.name)],
                datasets: [{
                    label: "Number of Coures by Category",
                    data: [...coursesCategoryData.map(cat => cat.courseCount)],
                    backgroundColor: ["#4d7de4", "#b28cc8", "#4cb982", ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom"
                    }
                },
            }
        });
    </script>
</body>

</html>
je veuw avoir le meme tableau de board avec un structure de luxe et tout es donne dynaimiques pour tous types user