module.exports = function(grunt) {
    grunt.initConfig({
		sass: {
			options: {
                includePaths: ['node_modules/bootstrap-sass/assets/stylesheets']
            },
            dist: {
				options: {
					outputStyle: 'compressed'
				},
                files: [{
                    'public/assets/css/mooli.min.css': 'resources/sass/app.scss', 	                        /* 'All main SCSS' */                
				}]
            }
        },
        uglify: {
          my_target: {
            files: {
                'public/assets/bundles/libscripts.bundle.js':          ['public/assets/vendor/jquery/jquery-3.3.1.min.js','public/assets/vendor/bootstrap/js/bootstrap.bundle.js','public/assets/vendor/topbar-master/prettify.min.js','public/assets/vendor/topbar-master/topbar.min.js'], /* main js*/
                'public/assets/bundles/vendorscripts.bundle.js':       ['public/assets/vendor/metisMenu/metisMenu.js','public/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js','public/assets/vendor/bootstrap-progressbar/js/bootstrap-progressbar.min.js','public/assets/vendor/jquery-sparkline/js/jquery.sparkline.min.js'], /* coman js*/
                
                'public/assets/bundles/mainscripts.bundle.js':         ['public/assets/js/common.js'], /*coman js*/

                'public/assets/bundles/apexcharts.bundle.js':          ['public/assets/vendor/apexcharts/apexcharts.min.js'], /* Apex chart js*/
                'public/assets/bundles/c3.bundle.js':                  ['public/assets/vendor/c3/c3.min.js','public/assets/vendor/c3/d3.v3.min.js'], /* c 3 chart js*/
                'public/assets/bundles/morrisscripts.bundle.js':       ['public/assets/vendor/raphael/raphael.min.js','public/assets/vendor/morrisjs/morris.js'], /* Morris Plugin Js */
                'public/assets/bundles/knob.bundle.js':                ['public/assets/vendor/jquery-knob/jquery.knob.min.js'], /* knob js*/
                'public/assets/bundles/chartist.bundle.js':            ['public/assets/vendor/chartist/js/chartist.min.js','public/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.min.js','public/assets/vendor/chartist-plugin-axistitle/chartist-plugin-axistitle.min.js','public/assets/vendor/chartist-plugin-legend-latest/chartist-plugin-legend.js','public/assets/vendor/chartist/Chart.bundle.js'], /*chartist js*/
                'public/assets/bundles/easypiechart.bundle.js':        ['public/assets/vendor/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js','public/assets/vendor/jquery.easy-pie-chart/easy-pie-chart.init.js'],
                'public/assets/bundles/flotscripts.bundle.js':         ['public/assets/vendor/flot-charts/jquery.flot.js','public/assets/vendor/flot-charts/jquery.flot.resize.js','public/assets/vendor/flot-charts/jquery.flot.pie.js','public/assets/vendor/flot-charts/jquery.flot.categories.js','public/assets/vendor/flot-charts/jquery.flot.time.js'], /* Flot Chart js*/                
                
                'public/assets/bundles/jvectormap.bundle.js':          ['public/assets/vendor/jvectormap/jquery-jvectormap-2.0.3.min.js','public/assets/vendor/jvectormap/jquery-jvectormap-world-mill-en.js','public/assets/vendor/jvectormap/jquery-jvectormap-in-mill.js','public/assets/vendor/jvectormap/jquery-jvectormap-us-aea-en.js'], /* jvectormap js*/
                'public/assets/bundles/fullcalendarscripts.bundle.js': ['public/assets/vendor/fullcalendar/moment.min.js','public/assets/vendor/fullcalendar/fullcalendar.js'],   /* calender page js */ 
                'public/assets/bundles/datatablescripts.bundle.js':    ['public/assets/vendor/jquery-datatable/jquery.dataTables.min.js','public/assets/vendor/jquery-datatable/dataTables.bootstrap4.min.js'], /* Jquery DataTable Plugin Js  */
                }
            }
        }                
    });
    grunt.loadNpmTasks("grunt-sass");
    grunt.loadNpmTasks('grunt-contrib-uglify');
    
    grunt.registerTask("buildcss", ["sass"]);	
    grunt.registerTask("buildjs", ["uglify"]);
};
