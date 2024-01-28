// // Book data organized by semester
// const semesterBooks = [
//   // BCA 1st Semester
//   [
//     {
//       name: "Computer Fundamentals and Applications",
//       image:
//         "https://sajhakitab.com/wp-content/uploads/2023/09/9ed9d978-1d5f-4f2e-88f1-ee1cc0df79c8.jpg",
//     },
//     {
//       name: "Society and Technology",
//       image:
//         "https://sajhakitab.com/wp-content/uploads/2023/09/88ec2348-8288-4d0d-ad0d-971d305968dd.jpg",
//     },
//     {
//       name: "English-I",
//       image:
//         "https://evyapari-v4masters.s3.ap-south-1.amazonaws.com/admin/images/cover_photos/1597227566055.jpg",
//     },
//     {
//       name: "Mathematics-I",
//       image:
//         "https://static-01.daraz.com.np/p/63f1b283fdad2dd52bd7d6f111e2a163.jpg",
//     },
//     {
//       name: "Digital Logic",
//       image: "https://sajhakitab.com/wp-content/uploads/2023/07/IMG_5311.jpeg",
//     },
//   ],

//   // BCA 2nd Semester
//   [
//     {
//       name: "C Programming",
//       image:
//         "https://static-01.daraz.com.np/p/7850a838c7112cc4ff8f48d6c2aa90e3.jpg",
//     },
//     {
//       name: "Financial Accounting",
//       image:
//         "https://static-01.daraz.com.np/p/64446ea306c511c21708e2a6cf86d240.jpg",
//     },
//     {
//       name: "English II",
//       image:
//         "https://static-01.daraz.com.np/p/cbf9eed6270b355cab7c393c6d10b623.jpg",
//     },
//     {
//       name: "Mathematics II",
//       image:
//         "https://static-01.daraz.com.np/p/d6e363f2097a36409bfe42f7d098880c.jpg",
//     },
//     {
//       name: "Microprocessor & Architecture",
//       image:
//         "https://heritagebooks.com.np/wp-content/uploads/2022/02/Microprocessor-and-Computer-Architecturte.jpg",
//     },
//   ],

//   // BCA 3rd Semester
//   [
//     {
//       name: "Data Structure & Algorithm",
//       image:
//         "https://heritagebooks.com.np/wp-content/uploads/2022/01/Data-Strctures-and-Algorithms.jpg",
//     },
//     {
//       name: "Probability & Statistics",
//       image: "https://heritagebooks.com.np/wp-content/uploads/2019/11/6.jpg",
//     },
//     {
//       name: "System Analysis & Design",
//       image:
//         "https://heritagebooks.com.np/wp-content/uploads/2023/01/Systen-Analysis-and-Design.jpg",
//     },
//     {
//       name: "OOP in Java",
//       image:
//         "https://static-01.daraz.com.np/p/1e5b41cb6ac64472881d48a68ff4a406.jpg",
//     },
//     {
//       name: "Web Technology",
//       image:
//         "https://heritagebooks.com.np/wp-content/uploads/2021/12/Web-technology.jpg",
//     },
//   ],

//   //BCA 4th Semester
//   [
//     {
//       name: "Operating System",
//       image:
//         "https://static-01.daraz.com.np/p/25bd7e7974452efd3a9a0662278f005e.jpg",
//     },
//     {
//       name: "Numerical Methods",
//       image:
//         "https://m.media-amazon.com/images/W/MEDIAX_792452-T2/images/I/71RBUEoX0CL._AC_UF1000,1000_QL80_.jpg",
//     },
//     {
//       name: "Software Engineering",
//       image:
//         "https://heritagebooks.com.np/wp-content/uploads/2023/03/Software-Engineering.jpg",
//     },
//     {
//       name: "Scripting Language",
//       image:
//         "https://static-01.daraz.com.np/p/d814990a141a8ee81f6346ff6df4324a.jpg",
//     },
//     {
//       name: "Database Management System",
//       image:
//         "https://weblary.com/wp-content/uploads/2023/02/WhatsApp-Image-2023-02-09-at-12.07.49-AM-2.jpeg",
//     },
//   ],
//   //BCA 5th Semester
//   [
//     {
//       name: "MIS & e-business",
//       image:
//         "https://static-01.daraz.com.np/p/548a660fc949b3a2a29beeb798e2dbc1.jpg",
//     },
//     {
//       name: "DotNet Technology",
//       image:
//         "https://www.meripustak.com/MeripustakStatic/FullImage/Dot-Net-Technology_369170.jpg",
//     },
//     {
//       name: "Computer Networking",
//       image:
//         "https://images.cdn3.buscalibre.com/fit-in/360x360/62/a6/62a6e8f108c4acf9358d32d547201a61.jpg",
//     },
//     {
//       name: "Introduction to Management",
//       image:
//         "https://m.media-amazon.com/images/W/MEDIAX_792452-T2/images/I/81QKaoFPy9L._AC_UF1000,1000_QL80_.jpg",
//     },
//     {
//       name: "Computer Graphics",
//       image: "https://lalchowk.in/lalchowk/pictures/1000124.jpg",
//     },
//   ],
//   //BCA 6th Semester
//   [
//     {
//       name: "Mobile Programming",
//       image:
//         "https://cdn.citymapia.com/kottayam/booksdeal/26430/Portfolio.jpg?biz=2596",
//     },
//     {
//       name: "Distributed System",
//       image:
//         "https://www.bcanepal.com/wp-content/uploads/2019/05/Distributed-System-BPB-Publication.jpg",
//     },
//     {
//       name: "Applied Economics",
//       image:
//         "https://static-01.daraz.com.np/p/296942e1b73d07b40c508f3b0b9c7c8d.png",
//     },
//     {
//       name: "Advance Java Programming",
//       image:
//         "https://www.bcanepal.com/wp-content/uploads/2019/05/Advanced-Java-Programming-CBS.jpg",
//     },
//     {
//       name: "Network Programming",
//       image:
//         "https://heritagebooks.com.np/wp-content/uploads/2022/02/Network-Programming-KEC-CRopped.jpg",
//     },
//   ],
//   //BCA 7th Semester
//   [
//     {
//       name: "Cyber Law & Professional Ethics",
//       image:
//         "https://www.tppl.org.in/2020/14675-large_default/cyber-laws-book-for-mba-4th-semester-sppu.jpg",
//     },
//     {
//       name: "Cloud Computing",
//       image:
//         "https://technicalpublications.in/cdn/shop/files/9789355854368_1_9a22863c-5dbc-43e0-8c8c-b9fb190e30e0.jpg?v=1691651796",
//     },
//   ],
//   //BCA 8th Semester
//   [
//     {
//       name: "Operational Research",
//       image:
//         "https://easyengineering.net/wp-content/uploads/2017/10/511mviwhAL.jpg",
//     },
//   ],
// ];

// // Function to add book elements to the grid container
// function addBooks(semesterIndex) {
//   const gridContainer = document.getElementById(`bookGrid${semesterIndex + 1}`);

//   semesterBooks[semesterIndex].forEach((book) => {
//     const bookDiv = document.createElement("div");
//     bookDiv.classList.add("books");

//     const image = document.createElement("img");
//     image.src = book.image;

//     const bookName = document.createElement("p");
//     bookName.textContent = book.name;

//     bookDiv.appendChild(image);
//     bookDiv.appendChild(bookName);
//     gridContainer.appendChild(bookDiv);
//   });
// }

// // Call the function to add books for each semester
// for (let i = 0; i < semesterBooks.length; i++) {
//   addBooks(i);
// }

// Dashboard Sidebar toogle
var sidebarOpen = false;
var sidebar = document.getElementById("sidebar");

function openSidebar() {
  if (!sidebarOpen) {
    sidebar.classList.add("sidebar-responsive");
    sidebarOpen = true;
  }
}

function closeSidebar() {
  if (sidebarOpen) {
    sidebar.classList.remove("sidebar-responsive");
    sidebarOpen = false;
  }
}
