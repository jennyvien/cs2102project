"""
Miniserver: estraz server for integrating the template system with the FoC server
"""

import time
import os
from watchdog.observers import Observer
from watchdog.events import PatternMatchingEventHandler
import paramiko
from jinja2 import Environment, FileSystemLoader

#constants
#input dir
targets = os.listdir('test')
filetypes = {".html", ".php"}
debug = 0 
# fix the output path
output = "testoutput"
if not os.path.exists(output):
	os.makedirs(output)

#initialize the directory (now points to templates folder)
env = Environment(loader = FileSystemLoader('templates'))

#write all files currently in the directory
for i in targets:	
	if os.path.splitext(i)[1] in filetypes:
		print("writing: ", i)
		template = env.get_template(i)
		temp = template.render()
		with open(os.path.join(output, i), 'w') as f:
			if not debug:
				f.write(temp)
			else:
				for i in temp:
					print(i)
					f.write(i)



#Handler
class MyHandler(PatternMatchingEventHandler):
	patterns = ["*.html", "*.php"]
	failed = []

	def process(self, event):
		"""
		 event.event_type 
		'modified' | 'created' | 'moved' | 'deleted'
		event.is_directory
			True | False
		event.src_path
			path/to/observed/file
		"""
		#file is processed here
		print(event.src_path, event.event_type)
		inFile = event.src_path
		template = env.get_template(os.path.basename(inFile))
		temp = template.render()
		with open (os.path.join(output, os.path.basename(inFile)), 'w') as f:
			print("writing: ", os.path.basename(inFile))
			f.write(temp)
		# for i in targets:	
		# 	if os.path.splitext(i)[1] in filetypes:
		# 		print("writing: ", i)
		# 		template = env.get_template(i)
		# 		temp = template.render()
		# 		with open(os.path.join(output, i), 'w') as f:
		# 				f.write(temp)
	def on_modified(self, event):
		self.process(event)

	def on_created(self, event):
		self.process(event)

if __name__ == "__main__":
	target = "test"
	observer = Observer()
	observer.schedule(MyHandler(), target)
	observer.start()

	try:
		while True:
			time.sleep(1)
	except KeyboardInterrupt:
		observer.stop()

	observer.join()
