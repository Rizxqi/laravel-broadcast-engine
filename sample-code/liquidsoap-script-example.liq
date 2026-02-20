set("log.file.path", "/var/log/liquidsoap.log")

playlist = playlist("/var/music/playlist.m3u")

output.icecast(
  %mp3(bitrate=128),
  host = "icecast",
  port = 8000,
  password = "hackme",
  mount = "stream.mp3",
  playlist
)